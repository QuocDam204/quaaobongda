@extends('layouts.customer.app')

@section('title', $sanPham->Ten_San_Pham)

@section('content')

<div class="container my-4">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($sanPham->Ten_San_Pham, 50) }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- Hình ảnh sản phẩm --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm sticky-top" style="top: 150px;">
                <div class="card-body p-3">
                    @php
                        $anhChinh = $sanPham->anhSanPhams->where('Anh_Chinh', true)->first() 
                                  ?? $sanPham->anhSanPhams->first();
                    @endphp
                    
                    @if($anhChinh)
                        <img src="{{ asset('storage/' . $anhChinh->Duong_Dan) }}" 
                             class="img-fluid rounded mb-3" 
                             id="mainImage"
                             alt="{{ $sanPham->Ten_San_Pham }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                            <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                        </div>
                    @endif

                    @if($sanPham->anhSanPhams->count() > 1)
                        <div class="row g-2">
                            @foreach($sanPham->anhSanPhams as $anh)
                                <div class="col-3">
                                    <img src="{{ asset('storage/' . $anh->Duong_Dan) }}" 
                                         class="img-thumbnail hover-card {{ $anh->Anh_Chinh ? 'border-primary border-2' : '' }}" 
                                         style="cursor: pointer;"
                                         alt="Ảnh {{ $loop->iteration }}"
                                         onclick="changeMainImage('{{ asset('storage/' . $anh->Duong_Dan) }}', this)">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Thông tin sản phẩm --}}
        <div class="col-lg-7">
            <div class="mb-4">
                <h1 class="h3 fw-bold mb-3">{{ $sanPham->Ten_San_Pham }}</h1>
                
                <div class="mb-3">
                    <span class="badge bg-info text-dark">{{ $sanPham->danhMuc->Ten_Danh_Muc }}</span>
                    @if($sanPham->thuongHieu)
                        <span class="badge bg-secondary">{{ $sanPham->thuongHieu->Ten_Thuong_Hieu }}</span>
                    @endif
                    <span class="badge {{ $sanPham->Trang_Thai == 'Dang_Ban' ? 'bg-success' : 'bg-danger' }}">
                        {{ $sanPham->Trang_Thai == 'Dang_Ban' ? 'Còn hàng' : 'Hết hàng' }}
                    </span>
                </div>

                @if($sanPham->Mo_Ta_Ngan)
                    <p class="text-muted fst-italic">{{ $sanPham->Mo_Ta_Ngan }}</p>
                @endif

                <div class="border-top border-bottom py-3 my-3">
                    <h3 class="text-danger mb-1 fw-bold" id="dynamic-price">
                        {{ number_format($sanPham->Gia_Khuyen_Mai ?? $sanPham->Gia_Goc, 0, ',', '.') }}đ
                    </h3>
                    
                    @if($sanPham->Gia_Khuyen_Mai)
                        <div id="original-price-block">
                            <span class="text-decoration-line-through text-muted">
                                {{ number_format($sanPham->Gia_Goc, 0, ',', '.') }}đ
                            </span>
                            <span class="badge bg-danger ms-2">
                                -{{ round((($sanPham->Gia_Goc - $sanPham->Gia_Khuyen_Mai) / $sanPham->Gia_Goc) * 100) }}%
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Form thêm giỏ hàng --}}
            <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm">
                @csrf
                <input type="hidden" name="Ma_Bien_The" id="Ma_Bien_The">

                {{-- Chọn size --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Chọn size <span class="text-danger">*</span></label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($sanPham->bienTheSanPhams->groupBy('size.Ten_Size') as $size => $bienThes)
                            <div>
                                <input type="radio" class="btn-check" name="size_select" 
                                       id="size_{{ $size }}" value="{{ $size }}"
                                       onchange="updateColors('{{ $size }}')">
                                <label class="btn btn-outline-dark" for="size_{{ $size }}">{{ $size }}</label>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-danger fw-bold d-block mt-1" id="sizeError"></small>
                </div>

                {{-- Chọn màu --}}
                <div class="mb-4" id="colorSection" style="display: none;">
                    <label class="form-label fw-bold">Chọn màu <span class="text-danger">*</span></label>
                    <div id="colorOptions"></div>
                    <small class="text-danger fw-bold d-block mt-1" id="colorError"></small>
                </div>

                {{-- Thông tin tồn kho --}}
                <div class="mb-4" id="stockInfo" style="display: none;">
                    <span class="badge bg-success" id="stockBadge"></span>
                </div>

                {{-- Số lượng --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Số lượng</label>
                    <div class="input-group" style="max-width: 150px;">
                        <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty()">
                            <i class="bi bi-dash"></i>
                        </button>
                        <input type="number" class="form-control text-center fw-bold" 
                               name="So_Luong" id="So_Luong" value="1" min="1" readonly>
                        <button type="button" class="btn btn-outline-secondary" onclick="increaseQty()">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>

                {{-- In tên số --}}
                <div class="card bg-light border-0 mb-4">
                    <div class="card-body">
                        <h6 class="mb-3 fw-bold">
                            <i class="bi bi-printer-fill text-primary"></i> In tên và số (Tùy chọn)
                        </h6>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="Ten_In_Ao" 
                                       placeholder="Tên in (VD: RONALDO)" maxlength="50">
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="So_In_Ao" 
                                       placeholder="Số áo (VD: 7)" min="0" max="99">
                            </div>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            <i class="bi bi-info-circle"></i> Miễn phí in ấn. Giao hàng thêm 1-2 ngày.
                        </small>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-cart-plus me-2"></i> THÊM VÀO GIỎ HÀNG
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Tiếp tục mua sắm
                    </a>
                </div>
            </form>

            {{-- Bảng Size Chuẩn --}}
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-rulers me-2"></i>Bảng Size Chuẩn</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Size</th>
                                    <th>Chiều cao (cm)</th>
                                    <th>Cân nặng (kg)</th>
                                    <th>Ngực (cm)</th>
                                    <th>Eo (cm)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">S</td>
                                    <td>155 - 165</td>
                                    <td>50 - 60</td>
                                    <td>86 - 90</td>
                                    <td>70 - 74</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">M</td>
                                    <td>165 - 172</td>
                                    <td>60 - 68</td>
                                    <td>90 - 94</td>
                                    <td>74 - 78</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">L</td>
                                    <td>172 - 178</td>
                                    <td>68 - 75</td>
                                    <td>94 - 98</td>
                                    <td>78 - 82</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">XL</td>
                                    <td>178 - 183</td>
                                    <td>75 - 82</td>
                                    <td>98 - 104</td>
                                    <td>82 - 88</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">XXL</td>
                                    <td>183 - 188</td>
                                    <td>82 - 90</td>
                                    <td>104 - 110</td>
                                    <td>88 - 94</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>

            {{-- Mô tả --}}
            @if($sanPham->Mo_Ta)
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-file-text me-2"></i>Mô tả chi tiết</h5>
                </div>
                <div class="card-body">
                    {!! nl2br(e($sanPham->Mo_Ta)) !!}
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Sản phẩm liên quan --}}
    @if($sanPhamLienQuan->count() > 0)
    <section class="mt-5 pt-4 border-top">
        <h3 class="mb-4 fw-bold">
            <i class="bi bi-stars text-warning me-2"></i>Sản phẩm liên quan
        </h3>
        <div class="row g-3">
            @foreach($sanPhamLienQuan as $sp)
                <div class="col-6 col-md-3">
                    @include('partials.product-card', ['sanPham' => $sp])
                </div>
            @endforeach
        </div>
    </section>
    @endif
</div>

@endsection

@push('scripts')
<script>
const bienThes = @json($sanPham->bienTheSanPhams);
const defaultPrice = "{{ number_format($sanPham->Gia_Khuyen_Mai ?? $sanPham->Gia_Goc, 0, ',', '.') }}đ";
let maxStock = 1;

// Map tên màu sang mã màu hex
const colorMap = {
    'Trắng': '#FFFFFF',
    'Đen': '#000000',
    'Xám': '#808080',
    'Đỏ': '#FF0000',
    'Cam': '#FF8800',
    'Vàng': '#FFFF00',
    'Xanh lá': '#00FF00',
    'Xanh dương': '#0000FF',
    'Xanh navy': '#000080',
    'Tím': '#800080',
    'Hồng': '#FFC0CB',
    'Nâu': '#8B4513',
    'Be': '#F5F5DC',
    'Kem': '#FFFDD0',
    'Xanh rêu': '#556B2F',
    'Bạc': '#C0C0C0',
    'Vàng gold': '#FFD700'
};

function getColorCode(colorName) {
    // Nếu là mã màu hex thì trả về luôn, nếu là tên thì lấy từ colorMap
    if (colorName.startsWith('#')) {
        return colorName;
    }
    return colorMap[colorName] || '#808080'; // Default xám nếu không tìm thấy
}

function formatCurrency(number) {
    return new Intl.NumberFormat('vi-VN').format(number) + 'đ';
}

function changeMainImage(src, element) {
    document.getElementById('mainImage').src = src;
    document.querySelectorAll('.img-thumbnail').forEach(img => {
        img.classList.remove('border-primary', 'border-2');
    });
    element.classList.add('border-primary', 'border-2');
}

function updateColors(size) {
    const colorSection = document.getElementById('colorSection');
    const colorOptions = document.getElementById('colorOptions');
    
    document.getElementById('dynamic-price').innerText = defaultPrice;
    const originalBlock = document.getElementById('original-price-block');
    if(originalBlock) originalBlock.style.display = 'block';

    const availableColors = bienThes.filter(bt => bt.size.Ten_Size === size);
    
    if (availableColors.length > 0) {
        colorSection.style.display = 'block';
        
        let html = '<div class="d-flex flex-wrap gap-2">';
        availableColors.forEach(bt => {
            const colorCode = getColorCode(bt.Mau_Sac);
            const borderColor = bt.Mau_Sac === 'Trắng' ? '#ddd' : colorCode;
            
            html += `
                <div>
                    <input type="radio" class="btn-check" name="color_select" 
                           id="color_${bt.Ma_Bien_The}" value="${bt.Ma_Bien_The}"
                           onchange="selectVariant('${bt.Ma_Bien_The}', ${bt.So_Luong_Ton})">
                    <label class="btn btn-outline-secondary d-flex align-items-center gap-2 px-3" 
                           for="color_${bt.Ma_Bien_The}"
                           style="min-width: 120px;">
                        <span style="width: 24px; height: 24px; background-color: ${colorCode}; 
                                     border: 2px solid ${borderColor}; border-radius: 50%; 
                                     box-shadow: 0 0 0 1px #fff, 0 0 0 2px #ddd;"></span>
                        <span class="fw-semibold">${bt.Mau_Sac}</span>
                    </label>
                </div>
            `;
        });
        html += '</div>';
        colorOptions.innerHTML = html;
    } else {
        colorSection.style.display = 'none';
    }
    
    document.getElementById('sizeError').textContent = '';
    document.getElementById('Ma_Bien_The').value = '';
    document.getElementById('stockInfo').style.display = 'none';
}

function selectVariant(maBienThe, soLuongTon) {
    document.getElementById('Ma_Bien_The').value = maBienThe;
    maxStock = soLuongTon;
    
    const variant = bienThes.find(item => item.Ma_Bien_The == maBienThe);
    if (variant) {
        document.getElementById('dynamic-price').innerText = formatCurrency(variant.Gia_Ban);
        const originalBlock = document.getElementById('original-price-block');
        if(originalBlock) originalBlock.style.display = 'none';
    }

    const stockInfo = document.getElementById('stockInfo');
    const stockBadge = document.getElementById('stockBadge');
    stockInfo.style.display = 'block';
    
    if (soLuongTon > 0) {
        stockBadge.textContent = `Còn ${soLuongTon} sản phẩm`;
        stockBadge.className = 'badge bg-success';
        document.getElementById('So_Luong').max = soLuongTon;
        document.getElementById('So_Luong').value = 1;
    } else {
        stockBadge.textContent = 'Hết hàng';
        stockBadge.className = 'badge bg-danger';
        document.getElementById('So_Luong').value = 0;
    }
    
    document.getElementById('colorError').textContent = '';
}

function increaseQty() {
    const input = document.getElementById('So_Luong');
    let val = parseInt(input.value);
    if (val < maxStock) input.value = val + 1;
}

function decreaseQty() {
    const input = document.getElementById('So_Luong');
    let val = parseInt(input.value);
    if (val > 1) input.value = val - 1;
}

// Hàm hiển thị thông báo Bootstrap Alert
function showAlert(message, type = 'danger') {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-${type === 'danger' ? 'exclamation-triangle' : 'check-circle'}-fill me-2"></i> 
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const container = document.querySelector('.container.my-4');
    const existingAlert = container.querySelector('.alert');
    
    if (existingAlert) {
        existingAlert.remove();
    }
    
    container.insertAdjacentHTML('afterbegin', alertHtml);
    
    // Scroll to top để thấy thông báo
    window.scrollTo({ top: 0, behavior: 'smooth' });
    
    // Auto dismiss sau 5 giây
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}

// Form validation
document.getElementById('addToCartForm').addEventListener('submit', function(e) {
    let valid = true;
    
    if (!document.querySelector('input[name="size_select"]:checked')) {
        document.getElementById('sizeError').textContent = 'Vui lòng chọn size!';
        valid = false;
    }
    
    const colorSection = document.getElementById('colorSection');
    if (colorSection.style.display !== 'none' && !document.querySelector('input[name="color_select"]:checked')) {
        document.getElementById('colorError').textContent = 'Vui lòng chọn màu!';
        valid = false;
    }
    
    if (!document.getElementById('Ma_Bien_The').value && valid) {
        showAlert('Vui lòng chọn đầy đủ phân loại hàng!');
        valid = false;
    }
    
    // Kiểm tra hết hàng
    if (valid && maxStock <= 0) {
        showAlert('Sản phẩm này hiện đã hết hàng. Vui lòng chọn phân loại khác!');
        valid = false;
    }
    
    // Kiểm tra số lượng
    const soLuong = parseInt(document.getElementById('So_Luong').value);
    if (valid && soLuong <= 0) {
        showAlert('Số lượng phải lớn hơn 0!');
        valid = false;
    }
    
    if (valid && soLuong > maxStock) {
        showAlert(`Số lượng tồn kho chỉ còn ${maxStock} sản phẩm!`);
        valid = false;
    }
    
    if (!valid) e.preventDefault();
});
</script>
@endpush