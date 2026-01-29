@extends('admin.layouts.app')

@section('title', 'Sửa Thương hiệu')

@section('content')
<div class="container my-4">

    <div class="card shadow-sm">
        <div class="card-header bg-warning">
            <h5 class="mb-0">
                <i class="bi bi-pencil"></i> Chỉnh sửa Thương hiệu
            </h5>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.thuonghieu.update', $thuongHieu->Ma_Thuong_Hieu) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="Ten_Thuong_Hieu" class="form-label">
                        Tên Thương hiệu <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('Ten_Thuong_Hieu') is-invalid @enderror" 
                           id="Ten_Thuong_Hieu" 
                           name="Ten_Thuong_Hieu" 
                           value="{{ old('Ten_Thuong_Hieu', $thuongHieu->Ten_Thuong_Hieu) }}"
                           placeholder="VD: Nike, Adidas, Puma, Under Armour..."
                           required>
                    @error('Ten_Thuong_Hieu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Tên thương hiệu phải là duy nhất</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle"></i> Cập nhật
                    </button>
                    <a href="{{ route('admin.thuonghieu.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Hủy
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection