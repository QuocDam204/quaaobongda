@extends('admin.layouts.app')

@section('title', 'Quản lý Size')

@section('content')
<div class="container-fluid px-4 my-4">

    {{-- Header & Nút Thêm --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold text-dark">
                <i class="bi bi-aspect-ratio me-2"></i>Quản Lý Kích Cỡ
            </h4>
            <p class="text-muted small mb-0">Danh sách các kích cỡ quần áo (S, M, L, XL...)</p>
        </div>
        <a href="{{ route('admin.size.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Thêm Size
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            {{-- Bảng dữ liệu --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-uppercase small text-muted">
                            <th class="py-3" style="width: 150px;">Tên Size</th>
                            <th class="py-3">Nhóm Size / Mô tả</th>
                            <th class="py-3 text-end" style="width: 150px;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sizes as $size)
                            <tr>                          
                                <td>
                                    {{-- Hiển thị Size giống cái mác áo --}}
                                    <span class="badge bg-white text-dark border border-secondary px-3 py-2 fs-6 shadow-sm">
                                        {{ $size->Ten_Size }}
                                    </span>
                                </td>
                                
                                <td>
                                    @if($size->Nhom_Size)
                                        {{-- Thêm style white-space: pre-line để nhận diện xuống dòng --}}
                                        <span class="text-dark" style="white-space: pre-line;">{{ $size->Nhom_Size }}</span>
                                    @else
                                        <span class="text-muted fst-italic small">Chưa phân nhóm</span>
                                    @endif
                                </td>
                                
                                <td class="text-end">
                                    <div class="btn-group">
                                        {{-- Nút Sửa --}}
                                        <a href="{{ route('admin.size.edit', $size->Ma_Size) }}" 
                                           class="btn btn-light text-primary btn-sm" 
                                           title="Chỉnh sửa">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        
                                        {{-- Nút Xóa --}}
                                        <form action="{{ route('admin.size.destroy', $size->Ma_Size) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Cảnh báo: Bạn có chắc muốn xóa size này không?')">
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
                                        <i class="bi bi-aspect-ratio fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="mb-0">Chưa có size nào được tạo.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Phân trang --}}
            <div class="d-flex justify-content-end mt-4">
                {{ $sizes->links() }}
            </div>

        </div>
    </div>
</div>

<style>
    /* CSS Tùy chỉnh (Đồng bộ với các trang khác) */
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