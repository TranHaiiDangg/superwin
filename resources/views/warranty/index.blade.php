@extends('layouts.app')

@section('title', 'Chính sách bảo hành - SuperWin')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Chính sách bảo hành</h1>
        <p class="text-muted">Cam kết bảo hành chính hãng cho mọi sản phẩm</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-shield-alt text-primary fa-3x mb-3"></i>
                    <h5>Bảo hành chính hãng</h5>
                    <p class="text-muted">Tất cả sản phẩm đều được bảo hành chính hãng từ 12-24 tháng tùy loại sản phẩm</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-tools text-primary fa-3x mb-3"></i>
                    <h5>Dịch vụ sửa chữa</h5>
                    <p class="text-muted">Đội ngũ kỹ thuật viên chuyên nghiệp, sửa chữa nhanh chóng, uy tín</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-undo text-primary fa-3x mb-3"></i>
                    <h5>Đổi trả miễn phí</h5>
                    <p class="text-muted">Đổi trả miễn phí trong vòng 30 ngày nếu sản phẩm có lỗi từ nhà sản xuất</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h4 class="text-center mb-4">Thông tin bảo hành</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Thời gian bảo hành:</h6>
                            <ul class="list-unstyled">
                                <li>• Máy bơm nước: 12-24 tháng</li>
                                <li>• Quạt công nghiệp: 12-18 tháng</li>
                                <li>• Phụ kiện: 6-12 tháng</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Điều kiện bảo hành:</h6>
                            <ul class="list-unstyled">
                                <li>• Còn tem bảo hành</li>
                                <li>• Không bị hỏng do lỗi người dùng</li>
                                <li>• Không bị ngập nước, cháy nổ</li>
                            </ul>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="text-center">
                        <h6>Liên hệ bảo hành</h6>
                        <p class="mb-2"><strong>Hotline:</strong> 0123 456 789</p>
                        <p class="mb-2"><strong>Email:</strong> warranty@superwin.com</p>
                        <p class="mb-0"><strong>Địa chỉ:</strong> 123 Đường ABC, Hà Nội</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 