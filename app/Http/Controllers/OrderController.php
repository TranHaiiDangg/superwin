<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
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
        $orders = Order::where('customer_email', $customer->email)
            ->with('orderDetails.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $customer = Auth::guard('customer')->user();

        // Kiểm tra quyền truy cập dựa trên thông tin khách hàng
        if ($order->customer_email !== $customer->email) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        $order->load('orderDetails.product');

        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        // Kiểm tra xem có dữ liệu giỏ hàng được gửi từ JavaScript không
        $cartData = request()->input('cart_data');

        if (!$cartData) {
            return redirect()->route('cart.index')->with('error', 'Vui lòng chọn sản phẩm từ giỏ hàng');
        }

        $customer = Auth::guard('customer')->user();

        // Lấy dữ liệu giỏ hàng từ localStorage
        $this->cartService->getCartFromLocalStorage($cartData);

        if (!$this->cartService->hasItems()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống');
        }

        $cartData = $this->cartService->getCartData();

        return view('orders.checkout', compact('customer', 'cartData'));
    }

    public function store(Request $request)
    {
        // Debug: Log tất cả dữ liệu request
        Log::info('OrderController::store called', [
            'all_input' => $request->all(),
            'headers' => $request->headers->all(),
            'method' => $request->method()
        ]);

        // Lấy dữ liệu giỏ hàng từ localStorage
        $cartData = $request->input('cart_data');

        if (!$cartData) {
            return redirect()->back()->with('error', 'Không tìm thấy dữ liệu giỏ hàng')->withInput();
        }

        $this->cartService->getCartFromLocalStorage($cartData);

        if (!$this->cartService->hasItems()) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống')->withInput();
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
            'cart_data' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $customer = Auth::guard('customer')->user();
            $cartData = $this->cartService->getCartData();

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
                'user_id' => null, // Để null vì không có user_id hợp lệ
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
                    'total_price' => $item['price'] * $item['quantity']
                ]);
            }

            // Lưu giỏ hàng vào database nếu user đã đăng nhập
            $this->cartService->syncToDatabase();

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

        // Kiểm tra quyền truy cập dựa trên thông tin khách hàng
        if ($order->customer_email !== $customer->email) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        $order->load('orderDetails.product');

        return view('orders.success', compact('order'));
    }

    public function cancel(Order $order)
    {
        $customer = Auth::guard('customer')->user();

        // Kiểm tra quyền truy cập dựa trên thông tin khách hàng
        if ($order->customer_email !== $customer->email) {
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
