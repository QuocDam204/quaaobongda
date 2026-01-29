@extends('admin.layouts.app')

@section('title', 'Thống kê Đơn hàng')

@section('content')
<div class="container my-4">

    <div class="mb-3">
        <a href="{{ route('admin.donhang.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    <!-- Bộ lọc thống kê -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">📊 Bộ lọc thống kê</h5>
            <form method="GET" action="{{ route('admin.donhang.statistics') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Từ ngày</label>
                        <input type="date" name="tu_ngay" class="form-control" 
                               value="{{ request('tu_ngay', date('Y-m-01')) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Đến ngày</label>
                        <input type="date" name="den_ngay" class="form-control" 
                               value="{{ request('den_ngay', date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="trang_thai" class="form-select">
                            <option value="">-- Tất cả --</option>
                            <option value="Cho_Xac_Nhan" {{ request('trang_thai') == 'Cho_Xac_Nhan' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="Da_Xac_Nhan" {{ request('trang_thai') == 'Da_Xac_Nhan' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="Dang_Giao" {{ request('trang_thai') == 'Dang_Giao' ? 'selected' : '' }}>Đang giao</option>
                            <option value="Hoan_Thanh" {{ request('trang_thai') == 'Hoan_Thanh' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="Huy" {{ request('trang_thai') == 'Huy' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Thống kê
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Thống kê tổng quan -->
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3 mb-4">
        
        {{-- Ô 1: Tổng đơn hàng --}}
        <div class="col"> {{-- SỬA: Đổi col-md-3 thành col --}}
            <div class="card bg-primary text-white shadow h-100"> {{-- Thêm h-100 để các ô cao bằng nhau --}}
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1" style="font-size: 0.9rem;">Tổng đơn</h6>
                            <h4 class="mb-0">{{ $tongDonHang }}</h4>
                        </div>
                        <div>
                            <i class="bi bi-cart-check fs-2 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ô 2: Doanh thu --}}
        <div class="col">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1" style="font-size: 0.9rem;">Doanh thu</h6>
                            <h5 class="mb-0">{{ number_format($doanhThu, 0, ',', '.') }}₫</h5>
                        </div>
                        <div>
                            <i class="bi bi-currency-dollar fs-2 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ô 3: Lợi nhuận --}}
        <div class="col">
            <div class="card bg-info text-white shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1" style="font-size: 0.9rem;">Lợi nhuận</h6>
                            <h5 class="mb-0">{{ number_format($loiNhuan ?? 0, 0, ',', '.') }}₫</h5>
                        </div>
                        <div>
                            <i class="bi bi-graph-up-arrow fs-2 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ô 4: Chờ xác nhận --}}
        <div class="col">
            <div class="card bg-warning text-white shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1" style="font-size: 0.9rem;">Chờ xác nhận</h6>
                            <h4 class="mb-0">{{ $choXacNhan }}</h4>
                        </div>
                        <div>
                            <i class="bi bi-clock-history fs-2 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ô 5: Đơn hủy --}}
        <div class="col">
            <div class="card bg-danger text-white shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1" style="font-size: 0.9rem;">Đơn hủy</h6>
                            <h4 class="mb-0">{{ $donHuy }}</h4>
                        </div>
                        <div>
                            <i class="bi bi-x-circle fs-2 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Biểu đồ thống kê theo trạng thái -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">📊 Thống số đơn hàng kê theo trạng thái</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Trạng thái</th>
                                <th class="text-end">Số đơn</th>
                                <th class="text-end">Tỷ lệ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($thongKeTheoTrangThai as $tk)
                                <tr>
                                    <td>
                                        @php
                                            $statusConfig = [
                                                'Cho_Xac_Nhan' => ['class' => 'warning', 'text' => 'Chờ xác nhận'],
                                                'Da_Xac_Nhan' => ['class' => 'info', 'text' => 'Đã xác nhận'],
                                                'Dang_Giao' => ['class' => 'primary', 'text' => 'Đang giao'],
                                                'Hoan_Thanh' => ['class' => 'success', 'text' => 'Hoàn thành'],
                                                'Huy' => ['class' => 'danger', 'text' => 'Đã hủy']
                                            ];
                                            $status = $statusConfig[$tk->Trang_Thai] ?? ['class' => 'secondary', 'text' => $tk->Trang_Thai];
                                        @endphp
                                        <span class="badge bg-{{ $status['class'] }}">{{ $status['text'] }}</span>
                                    </td>
                                    <td class="text-end"><strong>{{ $tk->so_luong }}</strong></td>
                                    <td class="text-end">
                                        {{ $tongDonHang > 0 ? number_format(($tk->so_luong / $tongDonHang) * 100, 1) : 0 }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">💰 Doanh thu theo trạng thái</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Trạng thái</th>
                                <th class="text-end">Doanh thu</th>
                                <th class="text-end">Tỷ lệ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doanhThuTheoTrangThai as $dt)
                                <tr>
                                    <td>
                                        @php
                                            $statusConfig = [
                                                'Cho_Xac_Nhan' => ['class' => 'warning', 'text' => 'Chờ xác nhận'],
                                                'Da_Xac_Nhan' => ['class' => 'info', 'text' => 'Đã xác nhận'],
                                                'Dang_Giao' => ['class' => 'primary', 'text' => 'Đang giao'],
                                                'Hoan_Thanh' => ['class' => 'success', 'text' => 'Hoàn thành'],
                                                'Huy' => ['class' => 'danger', 'text' => 'Đã hủy']
                                            ];
                                            $status = $statusConfig[$dt->Trang_Thai] ?? ['class' => 'secondary', 'text' => $dt->Trang_Thai];
                                        @endphp
                                        <span class="badge bg-{{ $status['class'] }}">{{ $status['text'] }}</span>
                                    </td>
                                    <td class="text-end">
                                        <strong>{{ number_format($dt->doanh_thu, 0, ',', '.') }}₫</strong>
                                    </td>
                                    <td class="text-end">
                                        {{ $doanhThu > 0 ? number_format(($dt->doanh_thu / $doanhThu) * 100, 1) : 0 }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top sản phẩm bán chạy -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning">
            <h5 class="mb-0">🔥 Top 10 sản phẩm bán chạy</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">Top</th>
                            <th>Tên sản phẩm</th>
                            <th style="width: 100px;">Size</th>
                            <th style="width: 120px;">Màu sắc</th>
                            <th class="text-end" style="width: 120px;">Số lượng bán</th>
                            <th class="text-end" style="width: 150px;">Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topSanPham as $index => $sp)
                            <tr>
                                <td class="text-center">
                                    @if($index == 0)
                                        <span class="badge bg-warning text-dark">🥇 1</span>
                                    @elseif($index == 1)
                                        <span class="badge bg-secondary">🥈 2</span>
                                    @elseif($index == 2)
                                        <span class="badge bg-danger">🥉 3</span>
                                    @else
                                        <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                    @endif
                                </td>
                                <td><strong>{{ $sp->ten_san_pham }}</strong></td>
                                <td>{{ $sp->size }}</td>
                                <td>{{ $sp->mau_sac }}</td>
                                <td class="text-end"><strong>{{ $sp->so_luong_ban }}</strong></td>
                                <td class="text-end">
                                    <strong class="text-success">{{ number_format($sp->doanh_thu, 0, ',', '.') }}₫</strong>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Chưa có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Nút xuất báo cáo -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">📄 Xuất báo cáo</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.donhang.export.excel') }}?{{ http_build_query(request()->all()) }}" 
                   class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Xuất Excel
                </a>
            </div>
        </div>
    </div>

</div>

<style>
    @media print {
        .no-print, .btn, .card-header { display: none !important; }
    }
</style>
@endsection