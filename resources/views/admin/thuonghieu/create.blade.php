@extends('admin.layouts.app')

@section('title', 'Thêm Thương hiệu')

@section('content')
<div class="container my-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-plus-circle"></i> Thêm Thương hiệu mới
            </h5>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.thuonghieu.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="Ten_Thuong_Hieu" class="form-label">
                        Tên Thương hiệu <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('Ten_Thuong_Hieu') is-invalid @enderror" 
                           id="Ten_Thuong_Hieu" 
                           name="Ten_Thuong_Hieu" 
                           value="{{ old('Ten_Thuong_Hieu') }}"
                           placeholder="VD: Nike, Adidas, Puma, Under Armour..."
                           required>
                    @error('Ten_Thuong_Hieu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Tên thương hiệu phải là duy nhất</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Lưu
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