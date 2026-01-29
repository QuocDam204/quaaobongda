@extends('admin.layouts.app')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="container-fluid px-4 my-4">

    {{-- Header & Nút Thống kê --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold text-dark">
                <i class="bi bi-cart-check me-2"></i>Quản Lý Đơn Hàng
            </h4>
            <p class="text-muted small mb-0">Theo dõi và xử lý các đơn đặt hàng từ khách</p>
        </div>
        <a href="{{ route('admin.donhang.statistics') }}" class="btn btn-info text-white shadow-sm fw-bold">
            <i class="bi bi-bar-chart-line me-1"></i> Xem Thống Kê
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            {{-- BỘ LỌC TÌM KIẾM --}}
            <form method="GET" action="{{ route('admin.donhang.index') }}" class="row g-3 mb-4 pb-4 border-bottom">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 bg-light" 
                               placeholder="Tìm mã đơn, tên khách, SĐT..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="trang_thai" class="form-select bg-light">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="Cho_Xac_Nhan" {{ request('trang_thai') == 'Cho_Xac_Nhan' ? 'selected' : '' }}>Chờ xác nhận</option>
                        <option value="Da_Xac_Nhan" {{ request('trang_thai') == 'Da_Xac_Nhan' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="Dang_Giao" {{ request('trang_thai') == 'Dang_Giao' ? 'selected' : '' }}>Đang giao hàng</option>
                        <option value="Hoan_Thanh" {{ request('trang_thai') == 'Hoan_Thanh' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="Huy" {{ request('trang_thai') == 'Huy' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-bold flex-grow: 1">
                        <i class="bi bi-funnel"></i> Lọc
                    </button>
                    <a href="{{ route('admin.donhang.index') }}" class="btn btn-light border text-secondary" title="Làm mới">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </form>

            {{-- BẢNG DỮ LIỆU --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-uppercase small text-muted">
                            <th class="py-3">Mã ĐH</th>
                            <th class="py-3">Ngày đặt</th>
                            <th class="py-3">Khách hàng</th>
                            <th class="py-3">Tổng tiền</th>
                            <th class="py-3 text-center">Trạng thái</th>
                            <th class="py-3 text-end" style="width: 150px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donHangs as $dh)
                            <tr>
                                {{-- Mã ĐH --}}
                                <td>
                                    <span class="fw-bold text-primary">#{{ $dh->Ma_Don_Hang }}</span>
                                </td>

                                {{-- Ngày đặt --}}
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $dh->Ngay_Dat->format('d/m/Y') }}</span>
                                        <small class="text-muted">{{ $dh->Ngay_Dat->format('H:i') }}</small>
                                    </div>
                                </td>

                                {{-- Khách hàng --}}
                                <td>
                                    <h6 class="mb-0 text-dark fw-bold">{{ $dh->Ho_Ten_Nguoi_Nhan }}</h6>
                                    <small class="text-muted"><i class="bi bi-telephone-fill me-1"></i>{{ $dh->So_Dien_Thoai_Nguoi_Nhan }}</small>
                                </td>

                                {{-- Tổng tiền --}}
                                <td>
                                    <span class="fw-bold text-danger fs-6">
                                        {{ number_format($dh->Tien_Thanh_Toan, 0, ',', '.') }}₫
                                    </span>
                                </td>

                                {{-- Trạng thái (Badge màu sắc) --}}
                                <td class="text-center">
                                    @php
                                        $statusMap = [
                                            'Cho_Xac_Nhan' => ['color' => 'warning', 'icon' => 'bi-hourglass-split', 'label' => 'Chờ xác nhận'],
                                            'Da_Xac_Nhan'  => ['color' => 'info', 'icon' => 'bi-clipboard-check', 'label' => 'Đã xác nhận'],
                                            'Dang_Giao'    => ['color' => 'primary', 'icon' => 'bi-truck', 'label' => 'Đang giao'],
                                            'Hoan_Thanh'   => ['color' => 'success', 'icon' => 'bi-check-circle-fill', 'label' => 'Hoàn thành'],
                                            'Huy'          => ['color' => 'danger', 'icon' => 'bi-x-circle-fill', 'label' => 'Đã hủy'],
                                        ];
                                        $st = $statusMap[$dh->Trang_Thai] ?? ['color' => 'secondary', 'icon' => 'bi-question', 'label' => $dh->Trang_Thai];
                                    @endphp
                                    <span class="badge bg-{{ $st['color'] }} bg-opacity-10 text-{{ $st['color'] }} px-3 py-2 rounded-pill border border-{{ $st['color'] }} border-opacity-25">
                                        <i class="bi {{ $st['icon'] }} me-1"></i> {{ $st['label'] }}
                                    </span>
                                </td>

                                {{-- Hành động --}}
                                <td class="text-end">
                                    <div class="btn-group">
                                        {{-- Xem chi tiết --}}
                                        <a href="{{ route('admin.donhang.show', $dh->Ma_Don_Hang) }}" 
                                           class="btn btn-light text-primary btn-sm" 
                                           title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- Xóa (Chỉ hiện khi đã hủy) --}}
                                        @if($dh->Trang_Thai === 'Huy')
                                            <form action="{{ route('admin.donhang.destroy', $dh->Ma_Don_Hang) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn đơn hàng này không?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light text-danger btn-sm" title="Xóa đơn hàng">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-cart-x fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="mb-0">Không tìm thấy đơn hàng nào phù hợp.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Phân trang --}}
            <div class="d-flex justify-content-end mt-4">
                {{ $donHangs->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>

<style>
    /* CSS Tùy chỉnh đồng bộ */
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
        border-bottom-color: #f1f5f9;
    }
    .btn-light {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
    }
    .btn-light:hover {
        background: #e9ecef;
        border-color: #dee2e6;
    }
</style>
@endsection