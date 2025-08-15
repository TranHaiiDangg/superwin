<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Order::where('user_id', $customer->id)
            ->with('orderDetails.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $customer = Auth::guard('customer')->user();

        // Kiểm tra quyền truy cập dựa trên customer ID
        if ($order->user_id !== $customer->id) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        $order->load('orderDetails.product');

        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $customer = Auth::guard('customer')->user();
        $cartData = null;
        $isBuyNow = false;

        // Debug: Log request parameters
        Log::info('Checkout request', [
            'buy_now' => request()->get('buy_now'),
            'product_id' => request()->get('product_id'),
            'quantity' => request()->get('quantity'),
            'all_params' => request()->all()
        ]);

        // Kiểm tra nếu là "Mua ngay"
        if (request()->has('buy_now') && request()->get('buy_now') == '1') {
            $productId = request()->get('product_id');
            $quantity = request()->get('quantity', 1);
            $variantId = request()->get('variant_id');

            Log::info('Buy now detected', [
                'product_id' => $productId,
                'quantity' => $quantity,
                'variant_id' => $variantId
            ]);

            if (!$productId) {
                Log::warning('No product_id provided');
                return redirect()->back()->with('error', 'Không tìm thấy thông tin sản phẩm');
            }

            $product = Product::find($productId);
            if (!$product) {
                Log::warning('Product not found', ['product_id' => $productId]);
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại');
            }

            Log::info('Product found', [
                'product_id' => $product->id,
                'product_name' => $product->name
            ]);

            // Xử lý biến thể nếu có
            $variantName = '';
            $variantCode = '';
            $finalPrice = $product->isOnSale ? $product->sale_price : $product->price;
            $finalProductName = $product->name;

            if ($variantId && $variantId !== 'none' && $variantId !== null) {
                $variant = \App\Models\ProductVariant::find($variantId);
                if ($variant) {
                    $variantName = $variant->name;
                    $variantCode = $variant->code;
                    $finalPrice = $variant->isOnSale ? $variant->price_sale : $variant->price;
                    // Sử dụng tên biến thể làm tên sản phẩm chính
                    $finalProductName = $variantName;
                }
            }

            // Tạo dữ liệu giỏ hàng cho mua ngay
            $cartData = [
                'items' => [
                    [
                        'id' => $product->id,
                        'name' => $finalProductName, // Sử dụng tên biến thể
                        'price' => $finalPrice,
                        'original_price' => $product->price,
                        'quantity' => (int)$quantity,
                        'image' => $product->baseImage ? $product->baseImage->url : '/image/sp1.png',
                        'slug' => $product->slug,
                        'variant_id' => $variantId,
                        'variant_name' => $variantName,
                        'variant_code' => $variantCode,
                        'attributes' => []
                    ]
                ],
                'total' => $finalPrice * (int)$quantity,
                'itemCount' => (int)$quantity,
                'isBuyNow' => true
            ];

            $isBuyNow = true;
        } else {
            // Kiểm tra xem có dữ liệu giỏ hàng được gửi từ JavaScript không
            $cartDataInput = request()->input('cart_data');

            if (!$cartDataInput) {
                return redirect()->route('cart.index')->with('error', 'Vui lòng chọn sản phẩm từ giỏ hàng');
            }

            // Lấy dữ liệu giỏ hàng từ localStorage
            $this->cartService->getCartFromLocalStorage($cartDataInput);

            if (!$this->cartService->hasItems()) {
                return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống');
            }

            $cartData = $this->cartService->getCartData();
        }

        return view('orders.checkout', compact('customer', 'cartData', 'isBuyNow'));
    }

    public function store(Request $request)
    {
        // Debug: Log tất cả dữ liệu request
        Log::info('OrderController::store called', [
            'all_input' => $request->all(),
            'headers' => $request->headers->all(),
            'method' => $request->method()
        ]);

        // Kiểm tra nếu là mua ngay
        $isBuyNow = $request->has('buy_now') && $request->get('buy_now') == '1';

        if (!$isBuyNow) {
            // Lấy dữ liệu giỏ hàng từ localStorage cho trường hợp thường
            $cartData = $request->input('cart_data');

            if (!$cartData) {
                return redirect()->back()->with('error', 'Không tìm thấy dữ liệu giỏ hàng')->withInput();
            }

            $this->cartService->getCartFromLocalStorage($cartData);

            if (!$this->cartService->hasItems()) {
                return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống')->withInput();
            }
        }

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_district' => 'required|string|max:100',
            'shipping_ward' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,vnpay',
            'customer_note' => 'nullable|string|max:1000',
            'cart_data' => $isBuyNow ? 'nullable|string' : 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $customer = Auth::guard('customer')->user();

            // Xử lý dữ liệu giỏ hàng
            $cartData = null;
            $isBuyNow = false;

            // Kiểm tra nếu là mua ngay
            if (request()->has('buy_now') && request()->get('buy_now') == '1') {
                $productId = request()->get('product_id');
                $quantity = request()->get('quantity', 1);
                $variantId = request()->get('variant_id');

                // Debug log để kiểm tra dữ liệu
                Log::info('Store method - Buy now data received', [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'variant_id' => $variantId,
                    'all_request_data' => request()->all()
                ]);

                $product = Product::find($productId);
                if (!$product) {
                    throw new \Exception('Sản phẩm không tồn tại');
                }

                // Xử lý biến thể nếu có
                $variantName = '';
                $variantCode = '';
                $finalPrice = $product->isOnSale ? $product->sale_price : $product->price;
                $finalProductName = $product->name; // Tên sản phẩm mặc định

                if ($variantId && $variantId !== 'none') {
                    $variant = \App\Models\ProductVariant::find($variantId);
                    if ($variant) {
                        $variantName = $variant->name;
                        $variantCode = $variant->code;
                        $finalPrice = $variant->isOnSale ? $variant->price_sale : $variant->price;
                        $finalProductName = $variantName; // Sử dụng tên biến thể làm tên sản phẩm chính

                        Log::info('Variant found and processed', [
                            'variant_id' => $variantId,
                            'variant_name' => $variantName,
                            'variant_code' => $variantCode,
                            'final_price' => $finalPrice,
                            'final_product_name' => $finalProductName
                        ]);
                    } else {
                        Log::warning('Variant not found', ['variant_id' => $variantId]);
                    }
                } else {
                    Log::info('No variant selected, using original product', [
                        'variant_id' => $variantId,
                        'final_product_name' => $finalProductName
                    ]);
                }

                $cartData = [
                    'items' => [
                        [
                            'id' => $product->id,
                            'name' => $finalProductName, // Sử dụng tên biến thể
                            'price' => $finalPrice,
                            'quantity' => (int)$quantity,
                            'sku' => $product->sku ?? '',
                            'variant_id' => $variantId,
                            'variant_name' => $variantName,
                            'variant_code' => $variantCode
                        ]
                    ],
                    'total' => $finalPrice * (int)$quantity
                ];
                $isBuyNow = true;

                Log::info('Final cart data for buy now', [
                    'cart_data' => $cartData
                ]);
            } else {
                $cartData = $this->cartService->getCartData();
            }

            // Tạo mã đơn hàng
            $orderCode = $this->generateOrderCode();

            // Tính toán giá
            $subtotal = $cartData['total'];
            $shippingFee = 30000; // Phí vận chuyển cố định
            $discount = 50000; // Giảm giá cố định
            $vat = $subtotal * 0.08; // VAT 8%
            $totalAmount = $subtotal + $shippingFee - $discount + $vat;

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => $customer->id, // Lưu customer ID
                'order_code' => $orderCode,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_district' => $request->shipping_district,
                'shipping_ward' => $request->shipping_ward,
                'payment_method' => $request->payment_method,
                'shipping_method' => 'standard',
                'shipping_fee' => $shippingFee,
                'discount_amount' => $discount,
                'tax_amount' => $vat,
                'subtotal' => $subtotal,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'customer_note' => $request->customer_note,
                'estimated_delivery_date' => now()->addDays(3)
            ]);

            // Cập nhật thông tin customer nếu có thay đổi
            Customer::where('id', $customer->id)->update([
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'email' => $request->customer_email,
                'address' => $request->shipping_address,
                'city' => $request->shipping_city,
                'district' => $request->shipping_district,
                'ward' => $request->shipping_ward,
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($cartData['items'] as $itemKey => $item) {
                // Đảm bảo item có đầy đủ thông tin cần thiết
                if (!isset($item['id']) || !isset($item['name']) || !isset($item['quantity'])) {
                    continue; // Bỏ qua item không hợp lệ
                }

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'product_sku' => $item['sku'] ?? '',
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'variant_name' => $item['variant_name'] ?? null,
                    'variant_code' => $item['variant_code'] ?? null
                ]);

                // Cập nhật sold_count của product
                $product = Product::find($item['id']);
                if ($product) {
                    $product->increment('sold_count', $item['quantity']);

                    Log::info('Updated product sold_count', [
                        'product_id' => $item['id'],
                        'product_name' => $item['name'],
                        'quantity_sold' => $item['quantity'],
                        'new_sold_count' => $product->fresh()->sold_count
                    ]);
                }
            }

            // Lưu giỏ hàng vào database nếu user đã đăng nhập và không phải mua ngay
            if (!$isBuyNow) {
                $this->cartService->syncToDatabase();
            }

            DB::commit();

            // Redirect đến trang thành công
            return redirect()->route('orders.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo đơn hàng: ' . $e->getMessage())->withInput();
        }
    }

    public function success(Order $order)
    {
        $customer = Auth::guard('customer')->user();

        // Kiểm tra quyền truy cập dựa trên customer ID
        if ($order->user_id !== $customer->id) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        $order->load('orderDetails.product');

        return view('orders.success', compact('order'));
    }

    public function cancel(Order $order)
    {
        $customer = Auth::guard('customer')->user();

        // Kiểm tra quyền truy cập dựa trên customer ID
        if ($order->user_id !== $customer->id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền hủy đơn hàng này'
            ], 403);
        }

        // Chỉ có thể hủy đơn hàng ở trạng thái pending hoặc confirmed
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể hủy đơn hàng ở trạng thái hiện tại'
            ], 400);
        }

        try {
            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancel_reason' => 'Khách hàng hủy đơn'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã hủy đơn hàng thành công'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi hủy đơn hàng'
            ], 500);
        }
    }

    protected function generateOrderCode()
    {
        do {
            $code = 'SW' . date('ymd') . strtoupper(Str::random(4));
        } while (Order::where('order_code', $code)->exists());

        return $code;
    }
}
