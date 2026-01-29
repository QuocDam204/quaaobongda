@extends('admin.layouts.app')

@section('title', 'Quản lý Sản phẩm')

@section('content')
<div class="container-fluid px-4 my-4">

    {{-- Header & Nút Thêm --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold text-dark">
                <i class="bi bi-box-seam me-2"></i>Quản Lý Sản Phẩm
            </h4>
            <p class="text-muted small mb-0">Danh sách quần áo, giá bán và trạng thái kho hàng</p>
        </div>
        <a href="{{ route('admin.sanpham.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Thêm Sản Phẩm
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            {{-- BỘ LỌC TÌM KIẾM --}}
            <form method="GET" action="{{ route('admin.sanpham.index') }}" class="row g-3 mb-4 pb-4 border-bottom">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 bg-light" 
                               placeholder="Tìm tên sản phẩm..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="danh_muc" class="form-select bg-light">
                        <option value="">-- Tất cả danh mục --</option>
                        @foreach($danhMucs as $dm)
                            <option value="{{ $dm->Ma_Danh_Muc }}" {{ request('danh_muc') == $dm->Ma_Danh_Muc ? 'selected' : '' }}>
                                {{ $dm->Ten_Danh_Muc }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="trang_thai" class="form-select bg-light">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="Dang_Ban" {{ request('trang_thai') == 'Dang_Ban' ? 'selected' : '' }}>Đang bán</option>
                        <option value="Ngung_Ban" {{ request('trang_thai') == 'Ngung_Ban' ? 'selected' : '' }}>Ngừng bán</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100 fw-bold">
                        Lọc Dữ Liệu
                    </button>
                </div>
            </form>

            {{-- BẢNG DỮ LIỆU --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-uppercase small text-muted">
                            <th style="width: 60px;">Ảnh</th>
                            <th style="width: 250px;">Tên Sản Phẩm</th>
                            <th>Phân Loại</th>
                            <th>Giá Nhập</th>
                            <th>Giá Bán</th>
                            <th class="text-center">Trạng Thái</th>
                            <th class="text-end" style="width: 180px;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sanPhams as $sp)
                            <tr>
                                {{-- 1. Cột Ảnh --}}
                                <td>
                                    @php
                                        $anhChinh = $sp->anhSanPhams->where('Anh_Chinh', true)->first() ?? $sp->anhSanPhams->first();
                                    @endphp
                                    <div class="rounded border d-flex align-items-center justify-content-center overflow-hidden" style="width: 50px; height: 50px;">
                                        @if($anhChinh)
                                            <img src="{{ asset('storage/' . $anhChinh->Duong_Dan) }}" alt="Img" class="w-100 h-100 object-fit-cover">
                                        @else
                                            <i class="bi bi-image text-muted"></i>
                                        @endif
                                    </div>
                                </td>

                                {{-- 2. Tên Sản Phẩm --}}
                                <td>
                                    <h6 class="mb-0 text-dark fw-bold text-truncate" style="max-width: 250px;">{{ $sp->Ten_San_Pham }}</h6>
                                </td>

                                {{-- 3. Phân Loại --}}
                                <td>
                                    <span class="badge bg-light text-dark border me-1">{{ $sp->danhMuc->Ten_Danh_Muc }}</span>
                                    @if($sp->thuongHieu)
                                        <span class="badge bg-light text-secondary border">{{ $sp->thuongHieu->Ten_Thuong_Hieu }}</span>
                                    @endif
                                </td>
                                
                                <td>
                                    <span class="text-secondary fw-bold">
                                        {{ number_format($sp->Gia_Nhap, 0, ',', '.') }}đ
                                    </span>
                                </td>

                                {{-- 4. Giá Bán --}}
                                <td>
                                    @if($sp->Gia_Khuyen_Mai)
                                        <div class="d-flex flex-column">
                                            <span class="text-danger fw-bold">{{ number_format($sp->Gia_Khuyen_Mai, 0, ',', '.') }}đ</span>
                                            <span class="text-muted text-decoration-line-through small">{{ number_format($sp->Gia_Goc, 0, ',', '.') }}đ</span>
                                        </div>
                                    @else
                                        <span class="fw-bold text-dark">{{ number_format($sp->Gia_Goc, 0, ',', '.') }}đ</span>
                                    @endif
                                </td>

                                {{-- 5. Trạng Thái --}}
                                <td class="text-center">
                                    @if($sp->Trang_Thai == 'Dang_Ban')
                                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i>Đang bán
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i>Ngừng bán
                                        </span>
                                    @endif
                                </td>

                                {{-- 6. Hành Động --}}
                                <td class="text-end">
                                    <div class="btn-group">
                                        {{-- Nút Biến thể (Size/Màu) --}}
                                        <a href="{{ route('admin.bienthe.index', $sp->Ma_San_Pham) }}" class="btn btn-light text-secondary btn-sm" title="Quản lý biến thể (Size/Số lượng)">
                                            <i class="bi bi-grid-3x3"></i>
                                        </a>

                                        {{-- Nút Xem --}}
                                        <a href="{{ route('admin.sanpham.show', $sp->Ma_San_Pham) }}" class="btn btn-light text-info btn-sm" title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- Nút Sửa --}}
                                        <a href="{{ route('admin.sanpham.edit', $sp->Ma_San_Pham) }}" class="btn btn-light text-primary btn-sm" title="Chỉnh sửa">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- Nút Xóa --}}
                                        <form action="{{ route('admin.sanpham.destroy', $sp->Ma_San_Pham) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-light text-danger btn-sm" title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="mb-0">Không tìm thấy sản phẩm nào phù hợp.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Phân trang --}}
            <div class="d-flex justify-content-end mt-4">
                {{ $sanPhams->links() }}
            </div>

        </div>
    </div>
</div>

<style>
    .table > :not(caption) > * > * { padding: 0.75rem 0.75rem; border-bottom-color: #f1f5f9; }
    .btn-light { background: #f8f9fa; border: 1px solid #e9ecef; }
    .btn-light:hover { background: #e9ecef; border-color: #dee2e6; }
    .object-fit-cover { object-fit: cover; }
</style>
@endsection