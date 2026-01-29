@extends('admin.layouts.app')

@section('title', 'Quản lý Biến thể')

@section('content')
<div class="container my-4">

    <!-- Thông tin sản phẩm -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">{{ $sanPham->Ten_San_Pham }}</h5>
                    <p class="text-muted mb-0">
                        <span class="badge bg-info">{{ $sanPham->danhMuc->Ten_Danh_Muc }}</span>
                        @if($sanPham->thuongHieu)
                            <span class="badge bg-secondary">{{ $sanPham->thuongHieu->Ten_Thuong_Hieu }}</span>
                        @endif
                        <span class="badge {{ $sanPham->Trang_Thai == 'Dang_Ban' ? 'bg-success' : 'bg-danger' }}">
                            {{ $sanPham->Trang_Thai == 'Dang_Ban' ? 'Đang bán' : 'Ngừng bán' }}
                        </span>
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.sanpham.show', $sanPham->Ma_San_Pham) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Về sản phẩm
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách biến thể -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">🔀 Danh sách Biến thể</h4>
                <a href="{{ route('admin.bienthe.create', $sanPham->Ma_San_Pham) }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Thêm biến thể
                </a>
            </div>

            @if($sanPham->bienTheSanPhams->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 100px;">Size</th>
                                <th style="width: 150px;">Màu sắc</th>
                                <th style="width: 120px;">SKU</th>
                                <th style="width: 120px;">Giá bán</th>
                                <th style="width: 100px;">Tồn kho</th>
                                <th style="width: 100px;">Trạng thái</th>
                                <th style="width: 180px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sanPham->bienTheSanPhams as $bt)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary fs-6">{{ $bt->size->Ten_Size }}</span>
                                    </td>
                                    <td>
                                        @php
                                            // Map tên màu sang mã màu để hiển thị
                                            $colorMap = [
                                                'Trắng' => '#FFFFFF',
                                                'Đen' => '#000000',
                                                'Xám' => '#808080',
                                                'Đỏ' => '#FF0000',
                                                'Cam' => '#FF8800',
                                                'Vàng' => '#FFFF00',
                                                'Xanh lá' => '#00FF00',
                                                'Xanh dương' => '#0000FF',
                                                'Xanh navy' => '#000080',
                                                'Tím' => '#800080',
                                                'Hồng' => '#FFC0CB',
                                                'Nâu' => '#8B4513',
                                                'Be' => '#F5F5DC',
                                                'Kem' => '#FFFDD0',
                                                'Xanh rêu' => '#556B2F',
                                                'Bạc' => '#C0C0C0',
                                                'Vàng gold' => '#FFD700'
                                            ];
                                            $displayColor = $colorMap[$bt->Mau_Sac] ?? $bt->Mau_Sac;
                                        @endphp
                                        <div class="d-flex align-items-center">
                                            <div style="width: 30px; height: 30px; background-color: {{ $displayColor }}; border: 2px solid #ddd; border-radius: 5px; margin-right: 10px;"></div>
                                            <span class="fw-semibold">{{ $bt->Mau_Sac }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $bt->SKU ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ number_format($bt->Gia_Ban, 0, ',', '.') }}đ</strong>
                                    </td>
                                    <td>
                                        <span class="badge {{ $bt->So_Luong_Ton > 10 ? 'bg-success' : ($bt->So_Luong_Ton > 0 ? 'bg-warning' : 'bg-danger') }} fs-6">
                                            {{ $bt->So_Luong_Ton }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $bt->Trang_Thai == 'Con_Hang' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $bt->Trang_Thai == 'Con_Hang' ? 'Còn hàng' : 'Hết hàng' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.bienthe.edit', [$sanPham->Ma_San_Pham, $bt->Ma_Bien_The]) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Sửa
                                        </a>

                                        <form action="{{ route('admin.bienthe.destroy', [$sanPham->Ma_San_Pham, $bt->Ma_Bien_The]) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc muốn xóa biến thể này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="5" class="text-end"><strong>Tổng tồn kho:</strong></td>
                                <td colspan="3">
                                    <strong class="text-primary">
                                        {{ $sanPham->bienTheSanPhams->sum('So_Luong_Ton') }} sản phẩm
                                    </strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="alert alert-warning text-center">
                    <i class="bi bi-exclamation-triangle"></i> 
                    Sản phẩm chưa có biến thể nào. Hãy thêm biến thể để có thể bán sản phẩm!
                </div>
            @endif

        </div>
    </div>

    <!-- Ghi chú -->
    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle"></i> 
        <strong>Lưu ý:</strong> Mỗi biến thể đại diện cho một sự kết hợp duy nhất giữa Size và Màu sắc. 
        Không thể có 2 biến thể trùng Size và Màu.
    </div>

</div>
@endsection