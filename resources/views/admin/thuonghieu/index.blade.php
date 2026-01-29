@extends('admin.layouts.app')

@section('title', 'Quản lý Thương hiệu')

@section('content')
<div class="container-fluid px-4 my-4">

    {{-- Header & Nút Thêm --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold text-dark">
                <i class="bi bi-tags-fill me-2"></i>Quản Lý Thương Hiệu
            </h4>
            <p class="text-muted small mb-0">Danh sách các hãng sản xuất (Nike, Adidas, Puma...)</p>
        </div>
        <a href="{{ route('admin.thuonghieu.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Thêm Thương Hiệu
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            {{-- Bảng dữ liệu --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-uppercase small text-muted">
                            <th class="py-3">Tên Thương Hiệu</th>
                            <th class="py-3 text-center" style="width: 200px;">Thống Kê</th>
                            <th class="py-3 text-end" style="width: 150px;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($thuongHieus as $th)
                            <tr>                                
                                <td>
                                    <span class="fw-bold text-dark fs-6">{{ $th->Ten_Thuong_Hieu }}</span>
                                </td>
                                
                                <td class="text-center">
                                    {{-- Hiển thị số lượng dạng Badge --}}
                                    @if($th->san_phams_count > 0)
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                            <i class="bi bi-box-seam me-1"></i> {{ $th->san_phams_count }} sản phẩm
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
                                            Chưa có SP
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="text-end">
                                    <div class="btn-group">
                                        {{-- Nút Sửa --}}
                                        <a href="{{ route('admin.thuonghieu.edit', $th->Ma_Thuong_Hieu) }}" 
                                           class="btn btn-light text-primary btn-sm" 
                                           title="Chỉnh sửa">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        
                                        {{-- Nút Xóa --}}
                                        <form action="{{ route('admin.thuonghieu.destroy', $th->Ma_Thuong_Hieu) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Cảnh báo: Xóa thương hiệu sẽ ảnh hưởng đến các sản phẩm thuộc thương hiệu này!\nBạn có chắc muốn xóa?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light text-danger btn-sm" title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-tag fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="mb-0">Chưa có thương hiệu nào.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Phân trang --}}
            <div class="d-flex justify-content-end mt-4">
                {{ $thuongHieus->links() }}
            </div>

        </div>
    </div>
</div>

<style>
    /* CSS Tùy chỉnh nhỏ cho bảng (Giống trang Danh mục) */
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
        border-bottom-color: #f1f5f9;
    }
    .btn-light {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
    }
    .btn-light:hover {
        background: #e9ecef;
        border-color: #dee2e6;
    }
</style>
@endsection