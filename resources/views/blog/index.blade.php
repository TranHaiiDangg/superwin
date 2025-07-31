@extends('layouts.app')

@section('title', 'Blog - SuperWin')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Blog</h1>
        <p class="text-muted">Chia sẻ kiến thức và kinh nghiệm về máy bơm nước, quạt công nghiệp</p>
    </div>

    <div class="text-center py-5">
        <i class="fas fa-blog fa-3x text-muted mb-3"></i>
        <h5>Đang phát triển</h5>
        <p class="text-muted">Trang blog sẽ sớm được cập nhật</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Về trang chủ</a>
    </div>
</div>
@endsection 