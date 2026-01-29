@extends('admin.layouts.app')

@section('title', 'Chi tiết Sản phẩm')

@section('content')
<div class="container my-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>
            <i class="bi bi-box-seam"></i> Chi tiết Sản phẩm
        </h4>
        <div>
            <a href="{{ route('admin.sanpham.edit', $sanPham->Ma_San_Pham) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Sửa
            </a>
            <a href="{{ route('admin.sanpham.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông tin cơ bản</h5>
                </div>
                <div class="card-body">
                    <h5>{{ $sanPham->Ten_San_Pham }}</h5>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Danh mục:</strong></div>
                        <div class="col-sm-9">
                            <span class="badge bg-info">{{ $sanPham->danhMuc->Ten_Danh_Muc }}</span>
                        </div>
                    </div>

                    @if($sanPham->thuongHieu)
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Thương hiệu:</strong></div>
                        <div class="col-sm-9">
                            <span class="badge bg-secondary">{{ $sanPham->thuongHieu->Ten_Thuong_Hieu }}</span>
                        </div>
                    </div>
                    @endif

                    {{-- === THÊM HIỂN THỊ GIÁ NHẬP === --}}
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Giá nhập (Vốn):</strong></div>
                        <div class="col-sm-9">
                            <span class="fs-5 text-secondary fw-bold">{{ number_format($sanPham->Gia_Nhap, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                    {{-- ============================== --}}

                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Giá gốc:</strong></div>
                        <div class="col-sm-9">
                            <span class="fs-5">{{ number_format($sanPham->Gia_Goc, 0, ',', '.') }}đ</span>
                        </div>
                    </div>

                    @if($sanPham->Gia_Khuyen_Mai)
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Giá khuyến mãi:</strong></div>
                        <div class="col-sm-9">
                            <span class="text-danger fs-5 fw-bold">{{ number_format($sanPham->Gia_Khuyen_Mai, 0, ',', '.') }}đ</span>
                            <span class="badge bg-danger ms-2">
                                Giảm {{ round((($sanPham->Gia_Goc - $sanPham->Gia_Khuyen_Mai) / $sanPham->Gia_Goc) * 100) }}%
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Trạng thái:</strong></div>
                        <div class="col-sm-9">
                            <span class="badge {{ $sanPham->Trang_Thai == 'Dang_Ban' ? 'bg-success' : 'bg-danger' }} fs-6">
                                {{ $sanPham->Trang_Thai == 'Dang_Ban' ? 'Đang bán' : 'Ngừng bán' }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Ngày tạo:</strong></div>
                        <div class="col-sm-9">{{ $sanPham->Ngay_Tao->format('d/m/Y H:i') }}</div>
                    </div>

                    @if($sanPham->Mo_Ta_Ngan)
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Mô tả ngắn:</strong></div>
                        <div class="col-sm-9">{{ $sanPham->Mo_Ta_Ngan }}</div>
                    </div>
                    @endif

                    @if($sanPham->Mo_Ta)
                    <div class="row">
                        <div class="col-sm-3"><strong>Mô tả chi tiết:</strong></div>
                        <div class="col-sm-9">
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($sanPham->Mo_Ta)) !!}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Biến thể sản phẩm</h5>
                    <a href="{{ route('admin.bienthe.index', $sanPham->Ma_San_Pham) }}" class="btn btn-light btn-sm">
                        <i class="bi bi-gear"></i> Quản lý biến thể
                    </a>
                </div>
                <div class="card-body">
                    @if($sanPham->bienTheSanPhams->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Size</th>
                                        <th>Màu sắc</th>
                                        <th>SKU</th>
                                        <th>Giá bán</th>
                                        <th>Tồn kho</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sanPham->bienTheSanPhams as $bt)
                                    <tr>
                                        <td><span class="badge bg-primary">{{ $bt->size->Ten_Size }}</span></td>
                                        <td>{{ $bt->Mau_Sac }}</td>
                                        <td><small class="text-muted">{{ $bt->SKU ?? '-' }}</small></td>
                                        <td>{{ number_format($bt->Gia_Ban, 0, ',', '.') }}đ</td>
                                        <td><strong>{{ $bt->So_Luong_Ton }}</strong></td>
                                        <td>
                                            <span class="badge {{ $bt->Trang_Thai == 'Con_Hang' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $bt->Trang_Thai == 'Con_Hang' ? 'Còn hàng' : 'Hết hàng' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-exclamation-triangle"></i> 
                            Sản phẩm chưa có biến thể nào. 
                            <a href="{{ route('admin.bienthe.create', $sanPham->Ma_San_Pham) }}">Thêm biến thể ngay</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Hình ảnh sản phẩm</h5>
                </div>
                <div class="card-body">
                    @if($sanPham->anhSanPhams->count() > 0)
                        <div class="row g-2">
                            @foreach($sanPham->anhSanPhams as $anh)
                                <div class="col-12">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $anh->Duong_Dan) }}" 
                                             class="img-fluid rounded" 
                                             alt="Ảnh sản phẩm">
                                    
                                        @if($anh->Anh_Chinh)
                                            <span class="position-absolute top-0 start-0 m-2 badge bg-success">
                                                Ảnh chính
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-image" style="font-size: 3rem;"></i>
                            <p class="mt-2">Chưa có hình ảnh</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection