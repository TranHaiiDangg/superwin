@extends('layouts.app')

@section('title', '419 - Phiên làm việc hết hạn')

@section('content')
<div class="error-page py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">
                <div class="error-content">
                    <!-- 419 Icon -->
                    <div class="error-icon mb-4">
                        <i class="fas fa-clock text-info" style="font-size: 5rem;"></i>
                    </div>

                    <!-- Error Message -->
                    <h1 class="error-title mb-3">419</h1>
                    <h2 class="error-subtitle mb-4">Phiên làm việc hết hạn</h2>

                    <p class="error-description mb-5">
                        Phiên làm việc của bạn đã hết hạn.
                        Vui lòng làm mới trang và thử lại để tiếp tục.
                    </p>

                    <!-- Action Buttons -->
                    <div class="error-actions">
                        <button onclick="location.reload()" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-redo me-2"></i>Làm mới trang
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg me-3">
                            <i class="fas fa-home me-2"></i>Về trang chủ
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập lại
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
    animation: rotate 3s linear infinite;
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
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
