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
                                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                                               id="city" name="city" value="{{ old('city', $customer->city) }}"
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
                                               id="district" name="district" value="{{ old('district', $customer->district) }}"
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
                                               id="ward" name="ward" value="{{ old('ward', $customer->ward) }}"
                                               placeholder="Nhập phường/xã" required>
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
@endsection
