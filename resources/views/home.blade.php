@extends('layouts.customer.app')

@section('title', 'Trang chủ - Shop Quần Áo Bóng Đá')

@section('content')

{{-- Hero Banner --}}
<section class="position-relative bg-dark">
    <a href="{{ route('products.index') }}" class="d-block">
        <img src="{{ asset('storage/banners/banner.png') }}" 
            alt="Shop Quần Áo Bóng Đá" 
            class="img-fluid w-100 opacity-75"
            style="max-height: 500px; object-fit: cover;">
        
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 text-center w-100 px-3">
            <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg fw-bold px-4 px-md-5 rounded-pill shadow-lg">
                <i class="bi bi-cart-fill me-2"></i> MUA SẮM NGAY
            </a>
        </div>
    </a>
</section>

{{-- Danh mục sản phẩm --}}
<section class="py-4 py-md-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-2">
                <i class="bi bi-grid-fill text-primary me-2"></i>
                Danh Mục Sản Phẩm
            </h2>
            <p class="text-muted small">Khám phá bộ sưu tập đa dạng</p>
        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
            @foreach($danhMucs as $dm)
                <div class="col">
                    <a href="{{ route('products.index', ['danh_muc' => $dm->Ma_Danh_Muc]) }}" 
                       class="text-decoration-none d-block">
                        <div class="card h-100 border-0 shadow-sm text-center p-3 category-card">
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-2" 
                                 style="width: 40px; height: 40px;">
                                <i class="bi bi-tshirt fs-3 text-primary"></i>
                            </div>
                            <h6 class="fw-bold mb-1 text-truncate small" title="{{ $dm->Ten_Danh_Muc }}">
                                {{ $dm->Ten_Danh_Muc }}
                            </h6>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                {{ $dm->san_phams_count }} Sản phẩm
                            </small>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Sản phẩm --}}
<section class="py-4 py-md-5 bg-white">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
            <div>
                <h2 class="fw-bold mb-1">
                    Sản Phẩm
                </h2>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary rounded-pill d-none d-md-block">
                Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-3 g-md-4">
            @forelse($sanPhamMoi as $sp)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('partials.product-card', ['sanPham' => $sp])
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Chưa có sản phẩm nào
                    </div>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill w-100">
                Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- Sản phẩm giảm giá --}}
@if($sanPhamGiamGia->count() > 0)
<section class="py-4 py-md-5 bg-danger bg-opacity-10">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-percent text-danger me-2"></i>
                    Đang Giảm Giá
                </h2>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-danger rounded-pill d-none d-md-block">
                Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($sanPhamGiamGia as $sp)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('partials.product-card', ['sanPham' => $sp])
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('products.index') }}" class="btn btn-danger rounded-pill w-100">
                Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- Features --}}
<section class="py-4 py-md-5 bg-white border-top">
    <div class="container">
        <div class="row g-3 g-md-4 text-center">
            <div class="col-6 col-lg-3">
                <div class="p-3 p-md-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 70px; height: 70px;">
                        <i class="bi bi-truck fs-2 text-primary"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Giao hàng nhanh</h5>
                    <p class="text-muted small mb-0">Toàn quốc 2-3 ngày</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="p-3 p-md-4">
                    <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 70px; height: 70px;">
                        <i class="bi bi-shield-check fs-2 text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Chính hãng 100%</h5>
                    <p class="text-muted small mb-0">Cam kết chất lượng</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="p-3 p-md-4">
                    <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 70px; height: 70px;">
                        <i class="bi bi-arrow-repeat fs-2 text-warning"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Đổi trả dễ dàng</h5>
                    <p class="text-muted small mb-0">Trong vòng 7 ngày</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="p-3 p-md-4">
                    <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 70px; height: 70px;">
                        <i class="bi bi-headset fs-2 text-info"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Hỗ trợ 24/7</h5>
                    <p class="text-muted small mb-0">Tư vấn nhiệt tình</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* Chỉ giữ lại CSS tối thiểu không có trong Bootstrap */
.category-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endpush