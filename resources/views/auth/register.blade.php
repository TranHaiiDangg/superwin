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
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                               id="city" name="city" value="{{ old('city') }}" 
                                               placeholder="Nhập tỉnh/thành phố" required>
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
                                        <input type="text" class="form-control @error('district') is-invalid @enderror" 
                                               id="district" name="district" value="{{ old('district') }}" 
                                               placeholder="Nhập quận/huyện" required>
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
                                        <input type="text" class="form-control @error('ward') is-invalid @enderror" 
                                               id="ward" name="ward" value="{{ old('ward') }}" 
                                               placeholder="Nhập phường/xã" required>
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
</script>
@endpush
@endsection 