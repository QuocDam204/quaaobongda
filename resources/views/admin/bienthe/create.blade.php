@extends('admin.layouts.app')

@section('title', 'Thêm Biến thể')

@section('content')
<div class="container my-4">

    <!-- Thông tin sản phẩm -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-1">{{ $sanPham->Ten_San_Pham }}</h5>
            <p class="text-muted mb-0">
                <span class="badge bg-info">{{ $sanPham->danhMuc->Ten_Danh_Muc }}</span>
            </p>
        </div>
    </div>

    <!-- Form thêm biến thể -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-plus-circle"></i> Thêm Biến thể mới
            </h5>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.bienthe.store', $sanPham->Ma_San_Pham) }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        
                        <div class="mb-3">
                            <label for="Ma_Size" class="form-label">
                                Size <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('Ma_Size') is-invalid @enderror" 
                                    id="Ma_Size" 
                                    name="Ma_Size"
                                    required>
                                <option value="">-- Chọn size --</option>
                                @foreach($sizes as $size)
                                    <option value="{{ $size->Ma_Size }}" 
                                            {{ old('Ma_Size') == $size->Ma_Size ? 'selected' : '' }}>
                                        {{ $size->Ten_Size }}
                                        @if($size->Nhom_Size)
                                            ({{ $size->Nhom_Size }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('Ma_Size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Mau_Sac" class="form-label">
                                Màu sắc <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('Mau_Sac') is-invalid @enderror" 
                                    id="Mau_Sac" 
                                    name="Mau_Sac"
                                    required>
                                <option value="">-- Chọn màu sắc --</option>
                                <option value="Trắng" data-color="#FFFFFF" {{ old('Mau_Sac') == 'Trắng' ? 'selected' : '' }}>⚪ Trắng</option>
                                <option value="Đen" data-color="#000000" {{ old('Mau_Sac') == 'Đen' ? 'selected' : '' }}>⚫ Đen</option>
                                <option value="Xám" data-color="#808080" {{ old('Mau_Sac') == 'Xám' ? 'selected' : '' }}>🔘 Xám</option>
                                <option value="Đỏ" data-color="#FF0000" {{ old('Mau_Sac') == 'Đỏ' ? 'selected' : '' }}>🔴 Đỏ</option>
                                <option value="Cam" data-color="#FF8800" {{ old('Mau_Sac') == 'Cam' ? 'selected' : '' }}>🟠 Cam</option>
                                <option value="Vàng" data-color="#FFFF00" {{ old('Mau_Sac') == 'Vàng' ? 'selected' : '' }}>🟡 Vàng</option>
                                <option value="Xanh lá" data-color="#00FF00" {{ old('Mau_Sac') == 'Xanh lá' ? 'selected' : '' }}>🟢 Xanh lá</option>
                                <option value="Xanh dương" data-color="#0000FF" {{ old('Mau_Sac') == 'Xanh dương' ? 'selected' : '' }}>🔵 Xanh dương</option>
                                <option value="Xanh navy" data-color="#000080" {{ old('Mau_Sac') == 'Xanh navy' ? 'selected' : '' }}>🔵 Xanh navy</option>
                                <option value="Tím" data-color="#800080" {{ old('Mau_Sac') == 'Tím' ? 'selected' : '' }}>🟣 Tím</option>
                                <option value="Hồng" data-color="#FFC0CB" {{ old('Mau_Sac') == 'Hồng' ? 'selected' : '' }}>🔴 Hồng</option>
                                <option value="Nâu" data-color="#8B4513" {{ old('Mau_Sac') == 'Nâu' ? 'selected' : '' }}>🟤 Nâu</option>
                                <option value="Be" data-color="#F5F5DC" {{ old('Mau_Sac') == 'Be' ? 'selected' : '' }}>🟨 Be</option>
                                <option value="Kem" data-color="#FFFDD0" {{ old('Mau_Sac') == 'Kem' ? 'selected' : '' }}>🟡 Kem</option>
                                <option value="Xanh rêu" data-color="#556B2F" {{ old('Mau_Sac') == 'Xanh rêu' ? 'selected' : '' }}>🟢 Xanh rêu</option>
                                <option value="Bạc" data-color="#C0C0C0" {{ old('Mau_Sac') == 'Bạc' ? 'selected' : '' }}>⚪ Bạc</option>
                                <option value="Vàng gold" data-color="#FFD700" {{ old('Mau_Sac') == 'Vàng gold' ? 'selected' : '' }}>🟡 Vàng gold</option>
                            </select>
                            @error('Mau_Sac')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Preview màu đã chọn -->
                            <div class="mt-2 d-flex align-items-center" id="colorPreview" style="display: none !important;">
                                <span class="me-2">Xem trước:</span>
                                <div id="colorBox" style="width: 40px; height: 40px; border: 2px solid #ddd; border-radius: 5px;"></div>
                                <span id="colorName" class="ms-2 fw-bold"></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="SKU" class="form-label">
                                Mã SKU <span class="text-muted">(Không bắt buộc)</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('SKU') is-invalid @enderror" 
                                   id="SKU" 
                                   name="SKU" 
                                   value="{{ old('SKU') }}"
                                   placeholder="VD: AO-MU-RED-M">
                            @error('SKU')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Mã định danh sản phẩm (nếu có)</small>
                        </div>

                    </div>

                    <div class="col-md-6">
                        
                        <div class="mb-3">
                            <label for="Gia_Ban" class="form-label">
                                Giá bán (VNĐ) <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('Gia_Ban') is-invalid @enderror" 
                                   id="Gia_Ban" 
                                   name="Gia_Ban" 
                                   value="{{ old('Gia_Ban', $sanPham->Gia_Khuyen_Mai ?? $sanPham->Gia_Goc) }}"
                                   min="0"
                                   step="1000"
                                   placeholder="VD: 500000"
                                   required>
                            @error('Gia_Ban')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Giá gốc sản phẩm: <strong>{{ number_format($sanPham->Gia_Goc, 0, ',', '.') }}đ</strong>
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="So_Luong_Ton" class="form-label">
                                Số lượng tồn kho <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('So_Luong_Ton') is-invalid @enderror" 
                                   id="So_Luong_Ton" 
                                   name="So_Luong_Ton" 
                                   value="{{ old('So_Luong_Ton', 0) }}"
                                   min="0"
                                   placeholder="VD: 100"
                                   required>
                            @error('So_Luong_Ton')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Trang_Thai" class="form-label">
                                Trạng thái <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('Trang_Thai') is-invalid @enderror" 
                                    id="Trang_Thai" 
                                    name="Trang_Thai"
                                    required>
                                <option value="Con_Hang" {{ old('Trang_Thai') == 'Con_Hang' ? 'selected' : '' }}>
                                    Còn hàng
                                </option>
                                <option value="Het_Hang" {{ old('Trang_Thai') == 'Het_Hang' ? 'selected' : '' }}>
                                    Hết hàng
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
                        <i class="bi bi-check-circle"></i> Lưu biến thể
                    </button>
                    <a href="{{ route('admin.bienthe.index', $sanPham->Ma_San_Pham) }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Hủy
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@push('scripts')
<script>
    // Hiển thị preview màu khi chọn
    const colorSelect = document.getElementById('Mau_Sac');
    const colorPreview = document.getElementById('colorPreview');
    const colorBox = document.getElementById('colorBox');
    const colorName = document.getElementById('colorName');
    
    colorSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const colorCode = selectedOption.getAttribute('data-color');
        const colorText = selectedOption.value;
        
        if (colorCode) {
            colorPreview.style.display = 'flex';
            colorBox.style.backgroundColor = colorCode;
            colorName.textContent = colorText;
        } else {
            colorPreview.style.display = 'none';
        }
    });
    
    // Hiển thị preview nếu đã có giá trị cũ
    if (colorSelect.value) {
        colorSelect.dispatchEvent(new Event('change'));
    }
</script>
@endpush
@endsection