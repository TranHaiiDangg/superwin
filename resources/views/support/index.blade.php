@extends('layouts.app')

@section('title', 'Hỗ trợ - SuperWin')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Hỗ trợ khách hàng</h1>
        <p class="text-muted">Chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-body p-4">
                    <i class="fas fa-phone text-primary fa-3x mb-3"></i>
                    <h5>Hotline</h5>
                    <p class="text-muted">028.6269.7382</p>
                    <p class="small text-muted">Thời gian: 8:00 - 22:00</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-body p-4">
                    <i class="fas fa-envelope text-primary fa-3x mb-3"></i>
                    <h5>Email</h5>
                    <p class="text-muted">superwin.vn@gmail.com</p>
                    <p class="small text-muted">Phản hồi trong 24h</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-body p-4">
                    <i class="fas fa-comments text-primary fa-3x mb-3"></i>
                    <h5>Zalo</h5>
                    <p class="text-muted">
                        <a href="https://zalo.me/0971687711" target="_blank" class="text-decoration-none">
                            0971687711
                        </a>
                    </p>
                    <p class="small text-muted">Chat trực tuyến</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <!-- <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h4 class="text-center mb-4">Gửi yêu cầu hỗ trợ</h4>
                    
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ tên *</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Tiêu đề *</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Nội dung *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Gửi yêu cầu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection 