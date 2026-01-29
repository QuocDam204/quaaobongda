@extends('layouts.customer.app')

@section('title', 'Danh sách sản phẩm')

@section('content')

<div class="container my-5">
    
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Sản phẩm</li>
        </ol>
    </nav>

    <div class="row">
        
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-funnel"></i> Bộ lọc</h5>
                </div>
                <div class="card-body">
                    
                    <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                        
                        <!-- Tìm kiếm -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tìm kiếm</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="search" 
                                   placeholder="Nhập tên sản phẩm..."
                                   value="{{ request('search') }}">
                        </div>

                        <!-- Danh mục -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Danh mục</label>
                            <select name="danh_muc" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                <option value="">-- Tất cả --</option>
                                @foreach($danhMucs as $dm)
                                    <option value="{{ $dm->Ma_Danh_Muc }}" 
                                            {{ request('danh_muc') == $dm->Ma_Danh_Muc ? 'selected' : '' }}>
                                        {{ $dm->Ten_Danh_Muc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Thương hiệu -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Thương hiệu</label>
                            <select name="thuong_hieu" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                <option value="">-- Tất cả --</option>
                                @foreach($thuongHieus as $th)
                                    <option value="{{ $th->Ma_Thuong_Hieu }}" 
                                            {{ request('thuong_hieu') == $th->Ma_Thuong_Hieu ? 'selected' : '' }}>
                                        {{ $th->Ten_Thuong_Hieu }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sắp xếp -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sắp xếp</label>
                            <select name="sort" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                <option value="moi_nhat" {{ request('sort') == 'moi_nhat' ? 'selected' : '' }}>
                                    Tất cả sản phẩm
                                </option>
                                <option value="gia_thap" {{ request('sort') == 'gia_thap' ? 'selected' : '' }}>
                                    Giá thấp đến cao
                                </option>
                                <option value="gia_cao" {{ request('sort') == 'gia_cao' ? 'selected' : '' }}>
                                    Giá cao đến thấp
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Tìm kiếm
                        </button>
                        
                        @if(request()->hasAny(['search', 'danh_muc', 'thuong_hieu', 'sort']))
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="bi bi-x-circle"></i> Xóa bộ lọc
                            </a>
                        @endif

                    </form>

                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            
            <!-- Results Info -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>
                    <i class="bi bi-grid-3x3"></i> 
                    Tất cả sản phẩm
                    <span class="badge bg-primary">{{ $sanPhams->total() }}</span>
                </h4>
                <div class="text-muted">
                    Hiển thị {{ $sanPhams->firstItem() ?? 0 }} - {{ $sanPhams->lastItem() ?? 0 }} 
                    trong {{ $sanPhams->total() }} sản phẩm
                </div>
            </div>

            <!-- Products -->
            <div class="row g-4">
                @forelse($sanPhams as $sp)
                    <div class="col-6 col-md-4">
                        @include('partials.product-card', ['sanPham' => $sp])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            <i class="bi bi-inbox"></i> 
                            <h5 class="mt-2">Không tìm thấy sản phẩm nào!</h5>
                            <p>Vui lòng thử lại với bộ lọc khác.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-clockwise"></i> Xem tất cả sản phẩm
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($sanPhams->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $sanPhams->links() }}
                </div>
            @endif

        </div>

    </div>

</div>

@endsection