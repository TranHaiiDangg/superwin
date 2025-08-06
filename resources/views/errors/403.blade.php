@extends('layouts.app')

@section('title', '403 - Không có quyền truy cập')

@section('content')
<div class="error-page py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">
                <div class="error-content">
                    <!-- 403 Icon -->
                    <div class="error-icon mb-4">
                        <i class="fas fa-lock text-warning" style="font-size: 5rem;"></i>
                    </div>

                    <!-- Error Message -->
                    <h1 class="error-title mb-3">403</h1>
                    <h2 class="error-subtitle mb-4">Không có quyền truy cập</h2>

                    <p class="error-description mb-5">
                        Bạn không có quyền truy cập vào trang này.
                        Vui lòng đăng nhập hoặc liên hệ với quản trị viên nếu bạn nghĩ đây là lỗi.
                    </p>

                    <!-- Action Buttons -->
                    <div class="error-actions">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-home me-2"></i>Về trang chủ
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg me-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-envelope me-2"></i>Liên hệ hỗ trợ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 70vh;
    display: flex;
    align-items: center;
}

.error-content {
    background: white;
    border-radius: 20px;
    padding: 60px 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.error-icon {
    animation: shake 2s infinite;
}

@keyframes shake {
    0%, 100% {
        transform: translateX(0);
    }
    10%, 30%, 50%, 70%, 90% {
        transform: translateX(-5px);
    }
    20%, 40%, 60%, 80% {
        transform: translateX(5px);
    }
}

.error-title {
    font-size: 4rem;
    font-weight: bold;
    color: #dc3545;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.error-subtitle {
    font-size: 1.5rem;
    color: #6c757d;
    font-weight: 600;
}

.error-description {
    font-size: 1.1rem;
    color: #6c757d;
    line-height: 1.6;
}

.error-actions {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}

.error-actions .btn {
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.error-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Responsive */
@media (max-width: 768px) {
    .error-content {
        padding: 40px 20px;
    }

    .error-title {
        font-size: 3rem;
    }

    .error-subtitle {
        font-size: 1.2rem;
    }

    .error-actions {
        flex-direction: column;
        align-items: center;
    }

    .error-actions .btn {
        width: 100%;
        max-width: 300px;
    }
}
</style>
@endsection
