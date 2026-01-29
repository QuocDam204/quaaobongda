@extends('admin.layouts.app')

@section('title', 'Sửa Sản phẩm')

@section('content')
<div class="container my-4">

    <div class="card shadow-sm">
        <div class="card-header bg-warning">
            <h5 class="mb-0"><i class="bi bi-pencil"></i> Chỉnh sửa Sản phẩm</h5>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.sanpham.update', $sanPham->Ma_San_Pham) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="Ten_San_Pham" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="Ten_San_Pham" name="Ten_San_Pham" value="{{ old('Ten_San_Pham', $sanPham->Ten_San_Pham) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="Mo_Ta_Ngan" class="form-label">Mô tả ngắn</label>
                            <input type="text" class="form-control" id="Mo_Ta_Ngan" name="Mo_Ta_Ngan" value="{{ old('Mo_Ta_Ngan', $sanPham->Mo_Ta_Ngan) }}">
                        </div>

                        <div class="mb-3">
                            <label for="Mo_Ta" class="form-label">Mô tả chi tiết</label>
                            <textarea class="form-control" id="Mo_Ta" name="Mo_Ta" rows="6">{{ old('Mo_Ta', $sanPham->Mo_Ta) }}</textarea>
                        </div>

                        @if($sanPham->anhSanPhams->count() > 0)
                        <div class="mb-3">
                            <label class="form-label">Hình ảnh hiện tại</label>
                            <div class="row g-2">
                                @foreach($sanPham->anhSanPhams as $anh)
                                    <div class="col-md-3">
                                        <div class="card h-100">
                                            <img src="{{ asset('storage/' . $anh->Duong_Dan) }}" class="card-img-top" style="height: 120px; object-fit: cover;">
                                            <div class="card-body p-2 d-flex flex-column gap-2">
                                                @if($anh->Anh_Chinh)
                                                    <span class="badge bg-success w-100">Ảnh chính</span>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-success w-100" 
                                                            onclick="document.getElementById('form-set-main-{{ $anh->Ma_Anh }}').submit();">
                                                        Đặt làm chính
                                                    </button>
                                                @endif
                                                
                                                <button type="button" class="btn btn-sm btn-danger w-100" 
                                                        onclick="if(confirm('Xóa ảnh này?')) document.getElementById('form-delete-img-{{ $anh->Ma_Anh }}').submit();">
                                                    <i class="bi bi-trash"></i> Xóa
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="images" class="form-label">Thêm hình ảnh mới</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                            <small class="text-muted">Giữ Ctrl để chọn nhiều ảnh (Tối đa 5MB/ảnh)</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="Ma_Danh_Muc" class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-select" id="Ma_Danh_Muc" name="Ma_Danh_Muc" required>
                                @foreach($danhMucs as $dm)
                                    <option value="{{ $dm->Ma_Danh_Muc }}" {{ $sanPham->Ma_Danh_Muc == $dm->Ma_Danh_Muc ? 'selected' : '' }}>
                                        {{ $dm->Ten_Danh_Muc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="Ma_Thuong_Hieu" class="form-label">Thương hiệu</label>
                            <select class="form-select" id="Ma_Thuong_Hieu" name="Ma_Thuong_Hieu">
                                <option value="">-- Không chọn --</option>
                                @foreach($thuongHieus as $th)
                                    <option value="{{ $th->Ma_Thuong_Hieu }}" {{ $sanPham->Ma_Thuong_Hieu == $th->Ma_Thuong_Hieu ? 'selected' : '' }}>
                                        {{ $th->Ten_Thuong_Hieu }}
                                    </option>
                                @endforeach
                            </select>
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
                                    value="{{ old('Gia_Nhap', $sanPham->Gia_Nhap) }}"
                                    min="0"
                                    step="1000"
                                    required>
                                <span class="input-group-text">VNĐ</span>
                            </div>
                            @error('Gia_Nhap')
                                <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="Gia_Goc" class="form-label">Giá gốc (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="Gia_Goc" name="Gia_Goc" value="{{ old('Gia_Goc', $sanPham->Gia_Goc) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="Gia_Khuyen_Mai" class="form-label">Giá khuyến mãi (VNĐ)</label>
                            <input type="number" class="form-control" id="Gia_Khuyen_Mai" name="Gia_Khuyen_Mai" value="{{ old('Gia_Khuyen_Mai', $sanPham->Gia_Khuyen_Mai) }}">
                        </div>

                        <div class="mb-3">
                            <label for="Trang_Thai" class="form-label">Trạng thái</label>
                            <select class="form-select" id="Trang_Thai" name="Trang_Thai">
                                <option value="Dang_Ban" {{ $sanPham->Trang_Thai == 'Dang_Ban' ? 'selected' : '' }}>Đang bán</option>
                                <option value="Ngung_Ban" {{ $sanPham->Trang_Thai == 'Ngung_Ban' ? 'selected' : '' }}>Ngừng bán</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning"><i class="bi bi-check-circle"></i> Cập nhật</button>
                    <a href="{{ route('admin.sanpham.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Hủy</a>
                </div>
            </form> 
            </div>
    </div>
</div>

@foreach($sanPham->anhSanPhams as $anh)
    <form id="form-set-main-{{ $anh->Ma_Anh }}" 
          action="{{ route('admin.sanpham.setMainImage', [$sanPham->Ma_San_Pham, $anh->Ma_Anh]) }}" 
          method="POST" style="display: none;">
        @csrf
    </form>

    <form id="form-delete-img-{{ $anh->Ma_Anh }}" 
          action="{{ route('admin.sanpham.deleteImage', [$sanPham->Ma_San_Pham, $anh->Ma_Anh]) }}" 
          method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach

@endsection