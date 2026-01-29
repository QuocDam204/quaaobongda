@extends('admin.layouts.app')

@section('title', 'Sửa Danh mục')

@section('content')
<div class="container my-4" style="max-width: 800px;">

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3">
                <i class="bi bi-pencil-square"></i> Sửa Danh mục
            </h4>

            <div class="alert alert-secondary">
                <strong>Mã danh mục:</strong> {{ $danhMuc->Ma_Danh_Muc }}
            </div>

            <form action="{{ route('admin.danhmuc.update', $danhMuc->Ma_Danh_Muc) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Tên danh mục -->
                <div class="mb-3">
                    <label class="form-label">
                        Tên danh mục <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="Ten_Danh_Muc"
                           class="form-control @error('Ten_Danh_Muc') is-invalid @enderror"
                           value="{{ old('Ten_Danh_Muc', $danhMuc->Ten_Danh_Muc) }}"
                           placeholder="Ví dụ: Áo đấu, Quần đấu, Phụ kiện..."
                           autofocus>

                    @error('Ten_Danh_Muc')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save"></i> Cập nhật
                    </button>

                    <a href="{{ route('admin.danhmuc.index') }}" class="btn btn-secondary ms-2">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
