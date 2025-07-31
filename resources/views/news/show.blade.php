@extends('layouts.app')

@section('title', 'Tin tức - SuperWin')

@section('content')
<div class="container py-5">
    <div class="text-center py-5">
        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
        <h5>Đang phát triển</h5>
        <p class="text-muted">Trang tin tức sẽ sớm được cập nhật</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Về trang chủ</a>
    </div>
</div>
@endsection 