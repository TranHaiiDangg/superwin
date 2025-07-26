@extends('layouts.header')

@section('title', 'Trang chủ SuperWin')

@section('content')
    <div class="container-fluid">
        <div class="banner-wrapper">
            <div class="banner-grid">
                {{-- Main Banner --}}
                <div class="main-banner">
                    <div class="slider-column">
                        <div class="main-slider">
                            <div class="slide-container">
                                {{-- Clone of last slide (slide 3) --}}
                                <div class="slide">
                                    <img src="{{ asset('image/baner3.png') }}" alt="Banner 3" loading="lazy">
                                </div>
                                
                                {{-- Real slides --}}
                                <div class="slide">
                                    <img src="{{ asset('image/baner1.png') }}" alt="Banner 1" loading="lazy">
                                </div>
                                <div class="slide">
                                    <img src="{{ asset('image/baner2.png') }}" alt="Banner 2" loading="lazy">
                                </div>
                                <div class="slide">
                                    <img src="{{ asset('image/baner3.png') }}" alt="Banner 3" loading="lazy">
                                </div>
                                
                                {{-- Clone of first slide (slide 1) --}}
                                <div class="slide">
                                    <img src="{{ asset('image/baner1.png') }}" alt="Banner 1" loading="lazy">
                                </div>
                            </div>
                            
                            {{-- Navigation --}}
                            <button class="slider-nav prev" aria-label="Previous slide">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="slider-nav next" aria-label="Next slide">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            
                            {{-- Pagination Dots --}}
                            <div class="pagination-dots" role="tablist" aria-label="Slide navigation"></div>
                        </div>
                    </div>
                </div>
                
                {{-- Side Banner 1 --}}
                <div class="side-banner-1">
                    <div class="image-box">
                        <img src="{{ asset('image/baner1.png') }}" alt="Promotion 1" loading="lazy">
                    </div>
                </div>
                
                {{-- Side Banner 2 --}}
                <div class="side-banner-2">
                    <div class="image-box">
                        <img src="{{ asset('image/baner2.png') }}" alt="Promotion 2" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-menu">
    <a href="#" class="menu-item">
        <div class="icon-container">
            <img src="{{ asset('image/bom.png') }}" alt="Bơm Nước" class="menu-img" />
        </div>
        <p>Bơm Nước</p>
    </a>
</div>

@endsection