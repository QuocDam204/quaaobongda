@extends('admin.layouts.app')

@section('title', 'Thêm Size')

@section('content')
<div class="container my-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-plus-circle"></i> Thêm Size mới
            </h5>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.size.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="Ten_Size" class="form-label">
                        Tên Size <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('Ten_Size') is-invalid @enderror" 
                           id="Ten_Size" 
                           name="Ten_Size" 
                           value="{{ old('Ten_Size') }}"
                           placeholder="VD: S, M, L, XL, XXL..."
                           required>
                    @error('Ten_Size')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Tên size phải là duy nhất</small>
                </div>

                <div class="mb-3">
                    <label for="Nhom_Size" class="form-label">
                        Nhóm Size / Mô tả <span class="text-muted">(Không bắt buộc)</span>
                    </label>
                    {{-- Đổi input thành textarea --}}
                    <textarea class="form-control @error('Nhom_Size') is-invalid @enderror" 
                            id="Nhom_Size" 
                            name="Nhom_Size" 
                            rows="3" 
                            placeholder="VD: Size người lớn&#10;Size trẻ em&#10;Hàng nhập khẩu...">{{ old('Nhom_Size') }}</textarea>
                    
                    @error('Nhom_Size')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Nhấn Enter để xuống dòng.</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Lưu
                    </button>
                    <a href="{{ route('admin.size.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Hủy
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection