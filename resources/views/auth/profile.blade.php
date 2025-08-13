@extends('layouts.app')

@section('title', 'Thông tin tài khoản - SuperWin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user me-2"></i>Thông tin tài khoản
                    </h4>
                </div>
                <div class="card-body p-5">
                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Profile Form -->
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Personal Information -->
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark mb-3">Thông tin cá nhân</h6>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ và tên *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name', $customer->name) }}"
                                               placeholder="Nhập họ và tên" required>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control"
                                               id="email" value="{{ $customer->email }}"
                                               placeholder="Email" readonly>
                                    </div>
                                    <small class="text-muted">Email không thể thay đổi</small>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                               id="phone" name="phone" value="{{ old('phone', $customer->phone) }}"
                                               placeholder="Nhập số điện thoại" required>
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="customer_code" class="form-label">Mã khách hàng</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-id-card"></i>
                                        </span>
                                        <input type="text" class="form-control"
                                               id="customer_code" value="{{ $customer->customer_code }}"
                                               placeholder="Mã khách hàng" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark mb-3">Địa chỉ giao hàng</h6>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                               id="address" name="address" value="{{ old('address', $customer->address) }}"
                                               placeholder="Số nhà, tên đường" required>
                                    </div>
                                    @error('address')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="city" class="form-label">Tỉnh/Thành phố *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-city"></i>
                                        </span>
                                        <select class="form-select @error('city') is-invalid @enderror" 
                                               id="city" name="city" required>
                                            <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                        </select>
                                    </div>
                                    @error('city')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="district" class="form-label">Quận/Huyện *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-map"></i>
                                        </span>
                                        <select class="form-select @error('district') is-invalid @enderror" 
                                               id="district" name="district" required disabled>
                                            <option value="">-- Chọn Quận/Huyện --</option>
                                        </select>
                                    </div>
                                    @error('district')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="ward" class="form-label">Phường/Xã *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-home"></i>
                                        </span>
                                        <select class="form-select @error('ward') is-invalid @enderror" 
                                               id="ward" name="ward" required disabled>
                                            <option value="">-- Chọn Phường/Xã --</option>
                                        </select>
                                    </div>
                                    @error('ward')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left me-1"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-shopping-cart text-primary fa-2x mb-2"></i>
                            <h5 class="card-title">{{ $customer->orders_count ?? 0 }}</h5>
                            <p class="card-text text-muted">Đơn hàng</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-coins text-warning fa-2x mb-2"></i>
                            <h5 class="card-title">{{ number_format($customer->total_spent) }}đ</h5>
                            <p class="card-text text-muted">Tổng chi tiêu</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-star text-success fa-2x mb-2"></i>
                            <h5 class="card-title">{{ $customer->loyalty_points }}</h5>
                            <p class="card-text text-muted">Điểm tích lũy</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.form-select:disabled {
    background-color: #f8f9fa;
    opacity: 0.65;
}

.input-group .form-select {
    border-left: 0;
}

.input-group .input-group-text {
    background-color: #e9ecef;
    border-right: 0;
}

.address-loading {
    position: relative;
}

.address-loading::after {
    content: '';
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translateY(-50%) rotate(0deg); }
    100% { transform: translateY(-50%) rotate(360deg); }
}
</style>
@endpush

@push('scripts')
<script>
// Address Manager for Profile Page
class ProfileAddressManager {
    constructor() {
        this.citySelect = document.getElementById('city');
        this.districtSelect = document.getElementById('district');
        this.wardSelect = document.getElementById('ward');
        
        // Store current values for pre-selection
        this.currentCity = '{{ old("city", $customer->city) }}';
        this.currentDistrict = '{{ old("district", $customer->district) }}';
        this.currentWard = '{{ old("ward", $customer->ward) }}';
        
        this.init();
    }
    
    async init() {
        await this.loadProvinces();
        this.bindEvents();
    }
    
    async loadProvinces() {
        try {
            this.showLoading(this.citySelect, 'Đang tải tỉnh/thành phố...');
            
            const response = await fetch('/api/provinces');
            const data = await response.json();
            
            if (data.success && data.data) {
                this.populateSelect(this.citySelect, data.data, 'name', 'name', '-- Chọn Tỉnh/Thành phố --');
                this.citySelect.parentElement.classList.remove('address-loading');
                
                // Pre-select current city if exists
                if (this.currentCity) {
                    this.selectOptionByText(this.citySelect, this.currentCity);
                    // Load districts for current city
                    const selectedOption = this.citySelect.options[this.citySelect.selectedIndex];
                    if (selectedOption.dataset.code) {
                        await this.loadDistricts(selectedOption.dataset.code);
                    }
                }
            } else {
                this.showError(this.citySelect, 'Không thể tải danh sách tỉnh/thành phố');
            }
        } catch (error) {
            console.error('Error loading provinces:', error);
            this.showError(this.citySelect, 'Lỗi kết nối. Vui lòng thử lại');
        }
    }
    
    async loadDistricts(provinceCode) {
        try {
            this.showLoading(this.districtSelect, 'Đang tải quận/huyện...');
            this.resetSelect(this.wardSelect, '-- Chọn Phường/Xã --');
            this.wardSelect.disabled = true;
            
            const response = await fetch(`/api/districts/${provinceCode}`);
            const data = await response.json();
            
            if (data.success && data.data) {
                this.populateSelect(this.districtSelect, data.data, 'name', 'name', '-- Chọn Quận/Huyện --');
                this.districtSelect.parentElement.classList.remove('address-loading');
                
                // Pre-select current district if exists
                if (this.currentDistrict) {
                    this.selectOptionByText(this.districtSelect, this.currentDistrict);
                    // Load wards for current district
                    const selectedOption = this.districtSelect.options[this.districtSelect.selectedIndex];
                    if (selectedOption.dataset.code) {
                        await this.loadWards(selectedOption.dataset.code);
                    }
                }
            } else {
                this.showError(this.districtSelect, 'Không thể tải danh sách quận/huyện');
            }
        } catch (error) {
            console.error('Error loading districts:', error);
            this.showError(this.districtSelect, 'Lỗi kết nối. Vui lòng thử lại');
        }
    }
    
    async loadWards(districtCode) {
        try {
            this.showLoading(this.wardSelect, 'Đang tải phường/xã...');
            
            const response = await fetch(`/api/wards/${districtCode}`);
            const data = await response.json();
            
            if (data.success && data.data) {
                this.populateSelect(this.wardSelect, data.data, 'name', 'name', '-- Chọn Phường/Xã --');
                this.wardSelect.parentElement.classList.remove('address-loading');
                
                // Pre-select current ward if exists
                if (this.currentWard) {
                    this.selectOptionByText(this.wardSelect, this.currentWard);
                }
            } else {
                this.showError(this.wardSelect, 'Không thể tải danh sách phường/xã');
            }
        } catch (error) {
            console.error('Error loading wards:', error);
            this.showError(this.wardSelect, 'Lỗi kết nối. Vui lòng thử lại');
        }
    }
    
    populateSelect(select, items, valueField, textField, placeholder) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item[valueField];
            option.textContent = item[textField];
            option.dataset.code = item.code || '';
            select.appendChild(option);
        });
        
        select.disabled = false;
    }
    
    resetSelect(select, placeholder) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        select.disabled = true;
    }
    
    showLoading(select, message) {
        select.innerHTML = `<option value="" class="loading-option">${message}</option>`;
        select.disabled = true;
        select.parentElement.classList.add('address-loading');
    }
    
    showError(select, message) {
        select.innerHTML = `<option value="" class="error-option">${message}</option>`;
        select.disabled = true;
        select.parentElement.classList.remove('address-loading');
    }
    
    selectOptionByText(select, text) {
        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].textContent.trim() === text.trim()) {
                select.selectedIndex = i;
                break;
            }
        }
    }
    
    bindEvents() {
        this.citySelect.addEventListener('change', async (e) => {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const provinceCode = selectedOption.dataset.code;
            
            // Clear current values when changing city
            this.currentDistrict = '';
            this.currentWard = '';
            
            if (provinceCode) {
                await this.loadDistricts(provinceCode);
            } else {
                this.resetSelect(this.districtSelect, '-- Chọn Quận/Huyện --');
                this.resetSelect(this.wardSelect, '-- Chọn Phường/Xã --');
                this.districtSelect.disabled = true;
                this.wardSelect.disabled = true;
            }
        });
        
        this.districtSelect.addEventListener('change', async (e) => {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const districtCode = selectedOption.dataset.code;
            
            // Clear current ward when changing district
            this.currentWard = '';
            
            if (districtCode) {
                await this.loadWards(districtCode);
            } else {
                this.resetSelect(this.wardSelect, '-- Chọn Phường/Xã --');
                this.wardSelect.disabled = true;
            }
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    new ProfileAddressManager();
});
</script>
@endpush

@endsection
