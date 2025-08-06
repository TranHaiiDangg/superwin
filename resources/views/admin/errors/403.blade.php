@extends('admin.layouts.app')

@section('title', 'Không có quyền truy cập')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <!-- Icon lớn -->
                    <div class="mb-4">
                        <i class="fas fa-lock text-danger" style="font-size: 5rem; opacity: 0.5;"></i>
                    </div>
                    
                    <!-- Tiêu đề -->
                    <h1 class="display-4 text-danger mb-3">403</h1>
                    <h2 class="h4 text-muted mb-4">Không có quyền truy cập</h2>
                    
                    <!-- Thông báo -->
                    <div class="alert alert-danger border-0" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ $message ?? 'Bạn không có quyền truy cập chức năng này.' }}
                    </div>
                    
                    <!-- Thông tin bổ sung -->
                    <p class="text-muted mb-4">
                        Vui lòng liên hệ với quản trị viên để được cấp quyền truy cập, 
                        hoặc quay lại trang chính để tiếp tục sử dụng hệ thống.
                    </p>
                    
                    <!-- Nút hành động -->
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Về trang chính
                        </a>
                        
                        <button onclick="history.back()" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom styles cho trang 403 */
.card {
    border: none;
    border-radius: 15px;
}

.btn {
    border-radius: 25px;
    padding: 10px 25px;
    font-weight: 500;
}

.alert {
    border-radius: 10px;
    font-weight: 500;
}

/* Animation cho icon */
.fas.fa-lock {
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Responsive */
@media (max-width: 768px) {
    .display-4 {
        font-size: 3rem;
    }
    
    .fas.fa-lock {
        font-size: 3rem !important;
    }
    
    .d-flex.gap-3 {
        flex-direction: column;
        gap: 1rem !important;
    }
    
    .btn {
        width: 100%;
    }
}
</style>
@endsection