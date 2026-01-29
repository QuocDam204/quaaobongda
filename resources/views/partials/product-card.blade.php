{{-- 
    FILE: resources/views/partials/product-card.blade.php
    FIX: Đã loại bỏ nút thêm nhanh vào giỏ hàng
--}}

<style>
    .product-card-modern {
        border: 1px solid #f0f0f0;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
        transition: all 0.3s ease;
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .product-card-modern:hover {
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }
    .badge-discount-modern {
        position: absolute; top: 12px; left: 12px; z-index: 10;
        background-color: #dc3545; color: white;
        font-weight: 700; font-size: 0.75rem;
        padding: 4px 10px; border-radius: 6px;
    }
    .card-image-wrapper {
        padding: 15px;
        background: #f8f9fa;
        text-align: center;
        height: 220px;
        display: flex; align-items: center; justify-content: center;
        position: relative;
    }
    
    .btn-view-detail {
        border-radius: 50px; font-weight: 600; font-size: 0.85rem; padding: 8px 15px;
        border: 1px solid #0f172a; color: #0f172a; background: transparent;
        transition: all 0.2s; width: 100%;
    }
    .btn-view-detail:hover { background: #0f172a; color: white; }
</style>

@php
    // 1. LẤY ẢNH
    $anhObj = $sanPham->anhSanPhams->where('Anh_Chinh', true)->first() ?? $sanPham->anhSanPhams->first();
    $imgSrc = $anhObj ? ( \Illuminate\Support\Str::startsWith($anhObj->Duong_Dan, ['http']) ? $anhObj->Duong_Dan : asset('storage/' . $anhObj->Duong_Dan) ) : 'https://via.placeholder.com/300';

    // 2. TÍNH GIÁ
    $giaHienTai = $sanPham->Gia_Khuyen_Mai ?? $sanPham->Gia_Goc; 
    $giaGoc     = $sanPham->Gia_Goc;
    $percent    = ($giaGoc > 0 && $sanPham->Gia_Khuyen_Mai > 0 && $sanPham->Gia_Khuyen_Mai < $giaGoc) 
                  ? round((($giaGoc - $sanPham->Gia_Khuyen_Mai) / $giaGoc) * 100) : 0;
    
    $detailUrl = route('products.detail', $sanPham->Ma_San_Pham);
@endphp

<div class="product-card-modern">
    
    @if($percent > 0)
        <span class="badge-discount-modern">-{{ $percent }}%</span>
    @endif

    {{-- ẢNH SẢN PHẨM --}}
    <div class="card-image-wrapper">
        <a href="{{ $detailUrl }}" class="d-block w-100 h-100">
            <img src="{{ $imgSrc }}" class="img-fluid" alt="{{ $sanPham->Ten_San_Pham }}"
                 style="max-height: 100%; object-fit: contain;">
        </a>
    </div>

    {{-- THÔNG TIN --}}
    <div class="card-body p-3 d-flex flex-column text-center">
        @if($sanPham->danhMuc)
            <small class="text-muted text-uppercase mb-1" style="font-size: 0.7rem;">
                {{ $sanPham->danhMuc->Ten_Danh_Muc }}
            </small>
        @endif

        <h6 class="fw-bold mb-2 text-truncate">
            <a href="{{ $detailUrl }}" class="text-decoration-none text-dark" title="{{ $sanPham->Ten_San_Pham }}">
                {{ $sanPham->Ten_San_Pham }}
            </a>
        </h6>

        <div class="mb-3">
            @if($percent > 0)
                <span class="text-danger fw-bold fs-5 me-1">{{ number_format($giaHienTai, 0, ',', '.') }}đ</span>
                <span class="text-muted text-decoration-line-through small">{{ number_format($giaGoc, 0, ',', '.') }}đ</span>
            @else
                <span class="fw-bold fs-5 text-dark">{{ number_format($giaGoc, 0, ',', '.') }}đ</span>
            @endif
        </div>
        
        <div class="mt-auto">
            {{-- Chỉ hiển thị nút Xem Chi Tiết --}}
            <a href="{{ $detailUrl }}" class="btn btn-view-detail">
                Xem chi tiết
            </a>
        </div>
    </div>
</div>