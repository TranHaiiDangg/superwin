@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Khách hàng')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Chỉnh sửa Khách hàng</h1>
        <a href="{{ route('admin.customers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm">
        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <!-- Customer Basic Info -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Thông tin cơ bản</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Họ và tên *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $customer->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="customer_code" class="block text-sm font-medium text-gray-700 mb-2">Mã khách hàng</label>
                        <input type="text" id="customer_code" name="customer_code" value="{{ old('customer_code', $customer->customer_code) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('customer_code') border-red-500 @enderror"
                               readonly>
                        @error('customer_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $customer->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại *</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                               required>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Ngày sinh</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $customer->date_of_birth ? $customer->date_of_birth->format('Y-m-d') : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('date_of_birth') border-red-500 @enderror">
                        @error('date_of_birth')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Giới tính</label>
                        <select id="gender" name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('gender') border-red-500 @enderror">
                            <option value="">Chọn giới tính</option>
                            <option value="male" {{ old('gender', $customer->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                            <option value="female" {{ old('gender', $customer->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                            <option value="other" {{ old('gender', $customer->gender) == 'other' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('gender')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Địa chỉ</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ *</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $customer->address) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror"
                               required>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Tỉnh/Thành phố *</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $customer->city) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('city') border-red-500 @enderror"
                               required>
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">Quận/Huyện *</label>
                        <input type="text" id="district" name="district" value="{{ old('district', $customer->district) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('district') border-red-500 @enderror"
                               required>
                        @error('district')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ward" class="block text-sm font-medium text-gray-700 mb-2">Phường/Xã *</label>
                        <input type="text" id="ward" name="ward" value="{{ old('ward', $customer->ward) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('ward') border-red-500 @enderror"
                               required>
                        @error('ward')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Customer Status & Settings -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Trạng thái & Cài đặt</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Trạng thái *</label>
                        <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                            <option value="active" {{ old('status', $customer->status) == 'active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="inactive" {{ old('status', $customer->status) == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                            <option value="banned" {{ old('status', $customer->status) == 'banned' ? 'selected' : '' }}>Bị cấm</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <div class="mt-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" 
                                       {{ old('is_active', $customer->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">
                                    <i class="fas fa-check-circle mr-1 text-blue-500"></i>Kích hoạt tài khoản
                                </span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1">Khách hàng có thể đăng nhập và sử dụng dịch vụ khi được kích hoạt</p>
                        </div>
                    </div>

                    <div>
                        <label for="preferred_payment_method" class="block text-sm font-medium text-gray-700 mb-2">Phương thức thanh toán ưa thích</label>
                        <select id="preferred_payment_method" name="preferred_payment_method" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('preferred_payment_method') border-red-500 @enderror">
                            <option value="">Chưa chọn</option>
                            <option value="cod" {{ old('preferred_payment_method', $customer->preferred_payment_method) == 'cod' ? 'selected' : '' }}>COD</option>
                            <option value="bank_transfer" {{ old('preferred_payment_method', $customer->preferred_payment_method) == 'bank_transfer' ? 'selected' : '' }}>Chuyển khoản</option>
                            <option value="momo" {{ old('preferred_payment_method', $customer->preferred_payment_method) == 'momo' ? 'selected' : '' }}>MoMo</option>
                            <option value="zalopay" {{ old('preferred_payment_method', $customer->preferred_payment_method) == 'zalopay' ? 'selected' : '' }}>ZaloPay</option>
                            <option value="vnpay" {{ old('preferred_payment_method', $customer->preferred_payment_method) == 'vnpay' ? 'selected' : '' }}>VNPay</option>
                        </select>
                        @error('preferred_payment_method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="newsletter_subscription" name="newsletter_subscription" value="1" 
                               {{ old('newsletter_subscription', $customer->newsletter_subscription) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="newsletter_subscription" class="ml-2 block text-sm text-gray-900">
                            Đăng ký nhận newsletter
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="marketing_consent" name="marketing_consent" value="1" 
                               {{ old('marketing_consent', $customer->marketing_consent) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="marketing_consent" class="ml-2 block text-sm text-gray-900">
                            Đồng ý nhận thông tin marketing
                        </label>
                    </div>
                </div>
            </div>

            <!-- Loyalty Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Thông tin tích lũy</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="total_spent" class="block text-sm font-medium text-gray-700 mb-2">Tổng chi tiêu (VNĐ)</label>
                        <input type="number" id="total_spent" name="total_spent" value="{{ old('total_spent', $customer->total_spent) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('total_spent') border-red-500 @enderror"
                               min="0" step="0.01">
                        @error('total_spent')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="loyalty_points" class="block text-sm font-medium text-gray-700 mb-2">Điểm tích lũy</label>
                        <input type="number" id="loyalty_points" name="loyalty_points" value="{{ old('loyalty_points', $customer->loyalty_points) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('loyalty_points') border-red-500 @enderror"
                               min="0">
                        @error('loyalty_points')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hạng khách hàng</label>
                        <div class="px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium
                                {{ $customer->loyalty_level == 'diamond' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $customer->loyalty_level == 'gold' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $customer->loyalty_level == 'silver' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $customer->loyalty_level == 'bronze' ? 'bg-orange-100 text-orange-800' : '' }}">
                                {{ ucfirst($customer->loyalty_level) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('admin.customers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Hủy
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i>Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 