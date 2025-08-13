@extends('layouts.app')

@section('title', 'Đăng ký - SuperWin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <img src="/image/logo.png" alt="SuperWin Logo" class="mb-3" style="height: 60px;">
                        <h4 class="fw-bold text-dark">Đăng ký tài khoản</h4>
                        <p class="text-muted">Tham gia SuperWin để nhận nhiều ưu đãi!</p>
                    </div>

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

                    <!-- Register Form -->
                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf
                        
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
                                               id="name" name="name" value="{{ old('name') }}" 
                                               placeholder="Nhập họ và tên" required>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email') }}" 
                                               placeholder="Nhập email" required>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone') }}" 
                                               placeholder="Nhập số điện thoại" required>
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" placeholder="Nhập mật khẩu" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation" 
                                               placeholder="Nhập lại mật khẩu" required>
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
                                               id="address" name="address" value="{{ old('address') }}" 
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

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="agree" name="agree" required>
                            <label class="form-check-label" for="agree">
                                Tôi đồng ý với <a href="#" class="text-decoration-none">Điều khoản sử dụng</a> và 
                                <a href="#" class="text-decoration-none">Chính sách bảo mật</a>
                            </label>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Đăng ký
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Đã có tài khoản? 
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                    Đăng nhập ngay
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Benefits -->
            <div class="row mt-4">
                <div class="col-md-4 text-center">
                    <div class="p-3">
                        <i class="fas fa-shipping-fast text-primary fa-2x mb-2"></i>
                        <h6>Giao hàng miễn phí</h6>
                        <p class="text-muted small">Cho đơn hàng từ 500k</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-3">
                        <i class="fas fa-shield-alt text-primary fa-2x mb-2"></i>
                        <h6>Bảo hành chính hãng</h6>
                        <p class="text-muted small">12-24 tháng tùy sản phẩm</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-3">
                        <i class="fas fa-headset text-primary fa-2x mb-2"></i>
                        <h6>Hỗ trợ 24/7</h6>
                        <p class="text-muted small">Tư vấn kỹ thuật miễn phí</p>
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

.loading-option {
    font-style: italic;
    color: #6c757d;
}

.error-option {
    color: #dc3545;
    font-weight: 500;
}

/* Custom styling for select elements */
.form-select option {
    padding: 8px 12px;
}

.form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Loading animation */
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
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Address API handlers
class AddressManager {
    constructor() {
        this.citySelect = document.getElementById('city');
        this.districtSelect = document.getElementById('district');
        this.wardSelect = document.getElementById('ward');
        
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
        
        // Enable the select after populating
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
    
    bindEvents() {
        this.citySelect.addEventListener('change', (e) => {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const provinceCode = selectedOption.dataset.code;
            

            
            if (provinceCode) {
                this.loadDistricts(provinceCode);
            } else {
                this.resetSelect(this.districtSelect, '-- Chọn Quận/Huyện --');
                this.resetSelect(this.wardSelect, '-- Chọn Phường/Xã --');
                this.districtSelect.disabled = true;
                this.wardSelect.disabled = true;
            }
        });
        
        this.districtSelect.addEventListener('change', (e) => {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const districtCode = selectedOption.dataset.code;
            

            
            if (districtCode) {
                this.loadWards(districtCode);
            } else {
                this.resetSelect(this.wardSelect, '-- Chọn Phường/Xã --');
                this.wardSelect.disabled = true;
            }
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    new AddressManager();
    

});
</script>
@endpush
@endsection 