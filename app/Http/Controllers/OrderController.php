<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // Kiểm tra quyền truy cập
        if ($order->user_id !== $customer->id) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        $order->load('orderDetails.product');

        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        if (!$this->cartService->hasItems()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống');
        }

        $customer = Auth::guard('customer')->user();
        $cartData = $this->cartService->getCartData();

        return view('orders.checkout', compact('customer', 'cartData'));
    }

    public function store(Request $request)
    {
        if (!$this->cartService->hasItems()) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng của bạn đang trống'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_district' => 'required|string|max:100',
            'shipping_ward' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,bank_transfer,credit_card',
            'customer_note' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $customer = Auth::guard('customer')->user();
            $cartData = $this->cartService->getCartData();

            // Tạo mã đơn hàng
            $orderCode = $this->generateOrderCode();

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => $customer->id,
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
                'shipping_fee' => 0, // Miễn phí vận chuyển
                'discount_amount' => 0,
                'tax_amount' => 0,
                'subtotal' => $cartData['total'],
                'total_amount' => $cartData['total'],
                'status' => 'pending',
                'customer_note' => $request->customer_note,
                'estimated_delivery_date' => now()->addDays(3)
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($cartData['items'] as $item) {
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

            // Xóa giỏ hàng
            $this->cartService->clear();

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đặt hàng thành công',
                    'order_id' => $order->id,
                    'order_code' => $order->order_code,
                    'redirect' => route('orders.success', $order->id)
                ]);
            }

            return redirect()->route('orders.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi tạo đơn hàng'
                ], 500);
            }

            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo đơn hàng')->withInput();
        }
    }

    public function success(Order $order)
    {
        $customer = Auth::guard('customer')->user();

        // Kiểm tra quyền truy cập
        if ($order->user_id !== $customer->id) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        $order->load('orderDetails.product');

        return view('orders.success', compact('order'));
    }

    public function cancel(Order $order)
    {
        $customer = Auth::guard('customer')->user();

        // Kiểm tra quyền truy cập
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
