@extends('admin.layouts.app')

@section('title', 'Thêm Sản phẩm')

@section('content')
<div class="container my-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-plus-circle"></i> Thêm Sản phẩm mới
            </h5>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.sanpham.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Cột trái -->
                    <div class="col-md-8">
                        
                        <div class="mb-3">
                            <label for="Ten_San_Pham" class="form-label">
                                Tên sản phẩm <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('Ten_San_Pham') is-invalid @enderror" 
                                   id="Ten_San_Pham" 
                                   name="Ten_San_Pham" 
                                   value="{{ old('Ten_San_Pham') }}"
                                   placeholder="VD: Áo đấu Manchester United 2024/25"
                                   required>
                            @error('Ten_San_Pham')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Mo_Ta_Ngan" class="form-label">
                                Mô tả ngắn
                            </label>
                            <input type="text" 
                                   class="form-control @error('Mo_Ta_Ngan') is-invalid @enderror" 
                                   id="Mo_Ta_Ngan" 
                                   name="Mo_Ta_Ngan" 
                                   value="{{ old('Mo_Ta_Ngan') }}"
                                   placeholder="Mô tả ngắn gọn về sản phẩm (tối đa 255 ký tự)">
                            @error('Mo_Ta_Ngan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Mo_Ta" class="form-label">
                                Mô tả chi tiết
                            </label>
                            <textarea class="form-control @error('Mo_Ta') is-invalid @enderror" 
                                      id="Mo_Ta" 
                                      name="Mo_Ta" 
                                      rows="6"
                                      placeholder="Mô tả chi tiết về sản phẩm, chất liệu, kích thước...">{{ old('Mo_Ta') }}</textarea>
                            @error('Mo_Ta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label">
                                Hình ảnh sản phẩm
                            </label>
                            <input type="file" 
                                   class="form-control @error('images.*') is-invalid @enderror" 
                                   id="images" 
                                   name="images[]" 
                                   multiple
                                   accept="image/*">
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Có thể chọn nhiều ảnh. Ảnh đầu tiên sẽ là ảnh chính. (JPG, PNG, tối đa 2MB/ảnh)
                            </small>
                        </div>

                    </div>

                    <!-- Cột phải -->
                    <div class="col-md-4">
                        
                        <div class="mb-3">
                            <label for="Ma_Danh_Muc" class="form-label">
                                Danh mục <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('Ma_Danh_Muc') is-invalid @enderror" 
                                    id="Ma_Danh_Muc" 
                                    name="Ma_Danh_Muc"
                                    required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($danhMucs as $dm)
                                    <option value="{{ $dm->Ma_Danh_Muc }}" 
                                            {{ old('Ma_Danh_Muc') == $dm->Ma_Danh_Muc ? 'selected' : '' }}>
                                        {{ $dm->Ten_Danh_Muc }}
                                    </option>
                                @endforeach
                            </select>
                            @error('Ma_Danh_Muc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Ma_Thuong_Hieu" class="form-label">
                                Thương hiệu
                            </label>
                            <select class="form-select @error('Ma_Thuong_Hieu') is-invalid @enderror" 
                                    id="Ma_Thuong_Hieu" 
                                    name="Ma_Thuong_Hieu">
                                <option value="">-- Không chọn --</option>
                                @foreach($thuongHieus as $th)
                                    <option value="{{ $th->Ma_Thuong_Hieu }}" 
                                            {{ old('Ma_Thuong_Hieu') == $th->Ma_Thuong_Hieu ? 'selected' : '' }}>
                                        {{ $th->Ten_Thuong_Hieu }}
                                    </option>
                                @endforeach
                            </select>
                            @error('Ma_Thuong_Hieu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Gia_Nhap" class="form-label">
                                Giá nhập (Vốn) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" 
                                    class="form-control @error('Gia_Nhap') is-invalid @enderror" 
                                    id="Gia_Nhap" 
                                    name="Gia_Nhap" 
                                    value="{{ old('Gia_Nhap') }}"
                                    min="0"
                                    step="1000"
                                    placeholder="VD: 300000"
                                    required>
                                <span class="input-group-text">VNĐ</span>
                            </div>
                            @error('Gia_Nhap')
                                <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Dùng để tính lợi nhuận.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="Gia_Goc" class="form-label">
                                Giá gốc (VNĐ) <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('Gia_Goc') is-invalid @enderror" 
                                   id="Gia_Goc" 
                                   name="Gia_Goc" 
                                   value="{{ old('Gia_Goc') }}"
                                   min="0"
                                   step="1000"
                                   placeholder="VD: 500000"
                                   required>
                            @error('Gia_Goc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Gia_Khuyen_Mai" class="form-label">
                                Giá khuyến mãi (VNĐ)
                            </label>
                            <input type="number" 
                                   class="form-control @error('Gia_Khuyen_Mai') is-invalid @enderror" 
                                   id="Gia_Khuyen_Mai" 
                                   name="Gia_Khuyen_Mai" 
                                   value="{{ old('Gia_Khuyen_Mai') }}"
                                   min="0"
                                   step="1000"
                                   placeholder="VD: 450000">
                            @error('Gia_Khuyen_Mai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Phải nhỏ hơn giá gốc</small>
                        </div>

                        <div class="mb-3">
                            <label for="Trang_Thai" class="form-label">
                                Trạng thái <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('Trang_Thai') is-invalid @enderror" 
                                    id="Trang_Thai" 
                                    name="Trang_Thai"
                                    required>
                                <option value="Dang_Ban" {{ old('Trang_Thai') == 'Dang_Ban' ? 'selected' : '' }}>
                                    Đang bán
                                </option>
                                <option value="Ngung_Ban" {{ old('Trang_Thai') == 'Ngung_Ban' ? 'selected' : '' }}>
                                    Ngừng bán
                                </option>
                            </select>
                            @error('Trang_Thai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Lưu sản phẩm
                    </button>
                    <a href="{{ route('admin.sanpham.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Hủy
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection