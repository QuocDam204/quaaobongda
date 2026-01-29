@extends('admin.layouts.app')

@section('title', 'Quản lý Danh mục')

@section('content')
<div class="container-fluid px-4 my-4">

    {{-- Header & Nút Thêm --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold text-dark"><i class="bi bi-folder2-open me-2"></i>Quản Lý Danh Mục</h4>
            <p class="text-muted small mb-0">Danh sách các loại áo đấu trong hệ thống</p>
        </div>
        <a href="{{ route('admin.danhmuc.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Thêm Danh Mục
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            
            {{-- Bảng dữ liệu (Đã xóa thanh tìm kiếm ở đây) --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-uppercase small text-muted">
                            <th class="py-3">Tên Danh Mục</th>
                            <th class="py-3 text-center" style="width: 200px;">Thống Kê</th>
                            <th class="py-3 text-end" style="width: 150px;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($danhMucs as $dm)
                            <tr>              
                                <td>
                                    <span class="fw-bold text-dark">{{ $dm->Ten_Danh_Muc }}</span>
                                </td>
                                
                                <td class="text-center">
                                    {{-- Hiển thị số lượng dạng Badge đẹp mắt --}}
                                    @if($dm->san_phams_count > 0)
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                            <i class="bi bi-box-seam me-1"></i> {{ $dm->san_phams_count }} sản phẩm
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
                                            Chưa có SP
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.danhmuc.edit', $dm->Ma_Danh_Muc) }}" 
                                           class="btn btn-light text-primary btn-sm" 
                                           title="Chỉnh sửa">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.danhmuc.destroy', $dm->Ma_Danh_Muc) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Cảnh báo: Xóa danh mục sẽ ảnh hưởng đến các sản phẩm bên trong!\nBạn có chắc muốn xóa?')">
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
                                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="mb-0">Không tìm thấy danh mục nào.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Phân trang --}}
            <div class="d-flex justify-content-end mt-4">
                {{ $danhMucs->links() }}
            </div>

        </div>
    </div>
</div>

<style>
    /* CSS Tùy chỉnh nhỏ cho bảng */
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