@extends('admin.layouts.app')

@section('title', 'Chi tiết Khách hàng')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Chi tiết Khách hàng</h1>
        <a href="{{ route('admin.customers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Customer Info -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0 h-20 w-20">
                        <div class="h-20 w-20 rounded-full bg-blue-500 flex items-center justify-center">
                            <span class="text-white font-bold text-2xl">{{ substr($customer->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $customer->name }}</h2>
                        <p class="text-gray-600">{{ $customer->customer_code }}</p>
                        <div class="flex items-center mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $customer->status == 'active' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $customer->status == 'inactive' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $customer->status == 'banned' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $customer->status == 'active' ? 'Hoạt động' : '' }}
                                {{ $customer->status == 'inactive' ? 'Không hoạt động' : '' }}
                                {{ $customer->status == 'banned' ? 'Bị cấm' : '' }}
                            </span>
                            <span class="ml-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $customer->loyalty_level == 'diamond' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $customer->loyalty_level == 'gold' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $customer->loyalty_level == 'silver' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $customer->loyalty_level == 'bronze' ? 'bg-orange-100 text-orange-800' : '' }}">
                                Hạng {{ ucfirst($customer->loyalty_level) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin liên hệ</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-gray-400 w-5"></i>
                                <span class="ml-3 text-gray-900">{{ $customer->email }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone text-gray-400 w-5"></i>
                                <span class="ml-3 text-gray-900">{{ $customer->phone }}</span>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-gray-400 w-5 mt-1"></i>
                                <div class="ml-3">
                                    <div class="text-gray-900">{{ $customer->address }}</div>
                                    <div class="text-gray-500 text-sm">{{ $customer->ward }}, {{ $customer->district }}, {{ $customer->city }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin khác</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ngày sinh:</span>
                                <span class="text-gray-900">{{ $customer->date_of_birth ? $customer->date_of_birth->format('d/m/Y') : 'Chưa cập nhật' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Giới tính:</span>
                                <span class="text-gray-900">{{ $customer->gender ? ucfirst($customer->gender) : 'Chưa cập nhật' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ngày tham gia:</span>
                                <span class="text-gray-900">{{ $customer->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Lần cuối đăng nhập:</span>
                                <span class="text-gray-900">{{ $customer->last_login_at ? $customer->last_login_at->format('d/m/Y H:i') : 'Chưa từng' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Đơn hàng gần đây</h3>
                @forelse($customer->orders()->latest()->take(5)->get() as $order)
                <div class="border-b border-gray-200 py-4 last:border-b-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="font-medium text-gray-900">{{ $order->order_code }}</div>
                            <div class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-medium text-gray-900">{{ number_format($order->total_amount) }}đ</div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-shopping-cart text-3xl mb-2"></i>
                    <p>Chưa có đơn hàng nào</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statistics -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Thống kê</h3>
                <div class="space-y-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $customer->orders()->count() }}</div>
                        <div class="text-sm text-gray-600">Tổng đơn hàng</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ number_format($customer->total_spent) }}đ</div>
                        <div class="text-sm text-gray-600">Tổng chi tiêu</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $customer->loyalty_points }}</div>
                        <div class="text-sm text-gray-600">Điểm tích lũy</div>
                    </div>
                </div>
            </div>

            <!-- Preferences -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tùy chọn</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Newsletter:</span>
                        <span class="{{ $customer->newsletter_subscription ? 'text-green-600' : 'text-red-600' }}">
                            <i class="fas {{ $customer->newsletter_subscription ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                            {{ $customer->newsletter_subscription ? 'Đăng ký' : 'Chưa đăng ký' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Marketing:</span>
                        <span class="{{ $customer->marketing_consent ? 'text-green-600' : 'text-red-600' }}">
                            <i class="fas {{ $customer->marketing_consent ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                            {{ $customer->marketing_consent ? 'Đồng ý' : 'Không đồng ý' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Phương thức thanh toán ưa thích:</span>
                        <span class="text-gray-900">{{ $customer->preferred_payment_method ?? 'Chưa chọn' }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Thao tác</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.customers.edit', $customer) }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-center block">
                        <i class="fas fa-edit mr-2"></i>Chỉnh sửa thông tin
                    </a>
                    
                    @if($customer->status !== 'banned')
                        <form method="POST" action="{{ route('admin.customers.ban', $customer) }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg"
                                    onclick="return confirm('Bạn có chắc muốn cấm khách hàng này?')">
                                <i class="fas fa-ban mr-2"></i>Cấm khách hàng
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.customers.unban', $customer) }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg"
                                    onclick="return confirm('Bạn có chắc muốn bỏ cấm khách hàng này?')">
                                <i class="fas fa-check-circle mr-2"></i>Bỏ cấm khách hàng
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 