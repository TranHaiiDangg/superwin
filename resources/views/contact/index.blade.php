@extends('layouts.app')

@section('title', 'Liên hệ - SuperWin')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Liên hệ với chúng tôi</h1>
        <p class="text-muted">Hãy để lại thông tin, chúng tôi sẽ liên hệ lại ngay!</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h4 class="mb-4">Gửi tin nhắn</h4>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ tên *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại *</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Tiêu đề *</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" name="subject" value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Nội dung *</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Gửi tin nhắn
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-4">Thông tin liên hệ</h5>
<!--                     
                    <div class="d-flex mb-3">
                        <i class="fas fa-map-marker-alt text-primary fa-lg me-3 mt-1"></i>
                        <div>
                            <h6 class="mb-1">Địa chỉ</h6>
                            <p class="text-muted mb-0">123 Đường ABC, Quận XYZ<br>Hà Nội, Việt Nam</p>
                        </div>
                    </div> -->
                    
                    <div class="d-flex mb-3">
                        <i class="fas fa-phone text-primary fa-lg me-3 mt-1"></i>
                        <div>
                            <h6 class="mb-1">Điện thoại</h6>
                            <p class="text-muted mb-0">028.6269.7382</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-3">
                        <i class="fas fa-envelope text-primary fa-lg me-3 mt-1"></i>
                        <div>
                            <h6 class="mb-1">Email</h6>
                            <p class="text-muted mb-0">superwin.vn@gmail.com</p>
                        </div>
                    </div>
                    
                    <!-- <div class="d-flex mb-3">
                        <i class="fas fa-clock text-primary fa-lg me-3 mt-1"></i>
                        <div>
                            <h6 class="mb-1">Giờ làm việc</h6>
                            <p class="text-muted mb-0">Thứ 2 - Thứ 7: 8:00 - 18:00<br>Chủ nhật: 9:00 - 16:00</p>
                        </div>
                    </div> -->
                    
                    <hr>
                    
                    <!-- <h6 class="mb-3">Theo dõi chúng tôi</h6>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 