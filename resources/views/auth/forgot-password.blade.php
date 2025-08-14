@extends('layouts.app')

@section('title', 'Quên mật khẩu - SuperWin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <img src="/image/logo.png" alt="SuperWin Logo" class="mb-3" style="height: 60px;">
                        <h4 class="fw-bold text-dark">Quên mật khẩu</h4>
                        <p class="text-muted">Nhập email của bạn để nhận link đặt lại mật khẩu</p>
                    </div>

                    <!-- Success/Error Messages -->
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
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

                    <!-- Forgot Password Form -->
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}"
                                       placeholder="Nhập email của bạn" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Gửi link đặt lại mật khẩu
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Nhớ mật khẩu rồi?
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                    Đăng nhập
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="text-center mt-4">
                <p class="text-muted small">
                    Link đặt lại mật khẩu sẽ được gửi đến email của bạn trong vòng vài phút.
                    Vui lòng kiểm tra cả thư mục spam nếu không thấy email.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
