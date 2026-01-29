@extends('admin.layouts.app')

@section('title', 'Chi tiết Đơn hàng #' . $donHang->Ma_Don_Hang)

@section('content')
<div class="container my-4">

    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('admin.donhang.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
        <a href="{{ route('admin.donhang.print', $donHang->Ma_Don_Hang) }}" 
           class="btn btn-primary" 
           target="_blank">
            <i class="bi bi-printer"></i> In đơn hàng
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📋 Thông tin đơn hàng #{{ $donHang->Ma_Don_Hang }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <strong>Ngày đặt:</strong> {{ $donHang->Ngay_Dat->format('d/m/Y H:i:s') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Trạng thái:</strong>
                            @php
                                $statusConfig = [
                                    'Cho_Xac_Nhan' => ['class' => 'warning', 'text' => 'Chờ xác nhận'],
                                    'Da_Xac_Nhan' => ['class' => 'info', 'text' => 'Đã xác nhận'],
                                    'Dang_Giao' => ['class' => 'primary', 'text' => 'Đang giao'],
                                    'Hoan_Thanh' => ['class' => 'success', 'text' => 'Hoàn thành'],
                                    'Huy' => ['class' => 'danger', 'text' => 'Đã hủy']
                                ];
                                $status = $statusConfig[$donHang->Trang_Thai] ?? ['class' => 'secondary', 'text' => $donHang->Trang_Thai];
                            @endphp
                            <span class="badge bg-{{ $status['class'] }}">{{ $status['text'] }}</span>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3"><strong>👤 Thông tin người nhận</strong></h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>Họ tên:</strong> {{ $donHang->Ho_Ten_Nguoi_Nhan }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Số điện thoại:</strong> {{ $donHang->So_Dien_Thoai_Nguoi_Nhan }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Email:</strong> {{ $donHang->Email_Nguoi_Nhan ?? 'Không có' }}
                        </div>
                        <div class="col-md-12 mb-2">
                            <strong>Địa chỉ giao:</strong> {{ $donHang->Dia_Chi_Giao }}
                        </div>
                        @if($donHang->Ghi_Chu)
                            <div class="col-md-12">
                                <strong>Ghi chú:</strong>
                                <p class="text-muted mb-0">{{ $donHang->Ghi_Chu }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">📦 Chi tiết sản phẩm</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th style="width: 100px;">Size</th>
                                    <th style="width: 100px;">Màu sắc</th>
                                    <th style="width: 100px;">In áo</th>
                                    <th style="width: 80px;">SL</th>
                                    <th style="width: 120px;">Đơn giá</th>
                                    <th style="width: 130px;">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($donHang->chiTietDonHangs as $ct)
                                    <tr>
                                        <td>
                                            {{-- ĐÃ SỬA: bienThe -> bienTheSanPham --}}
                                            <strong>{{ $ct->bienTheSanPham->sanPham->Ten_San_Pham ?? 'Sản phẩm đã xóa' }}</strong>
                                            <br>
                                            <small class="text-muted">SKU: {{ $ct->bienTheSanPham->SKU ?? 'N/A' }}</small>
                                        </td>
                                        <td>{{ $ct->bienTheSanPham->size->Ten_Size ?? 'N/A' }}</td>
                                        <td>{{ $ct->bienTheSanPham->Mau_Sac ?? 'N/A' }}</td>
                                        <td>
                                            @if($ct->Ten_In_Ao || $ct->So_In_Ao)
                                                <small>
                                                    {{ $ct->Ten_In_Ao ?? '' }}
                                                    @if($ct->So_In_Ao)
                                                        <br>#{{ $ct->So_In_Ao }}
                                                    @endif
                                                </small>
                                            @else
                                                <span class="text-muted">--</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $ct->So_Luong }}</td>
                                        <td class="text-end">{{ number_format($ct->Gia_Ban, 0, ',', '.') }}₫</td>
                                        <td class="text-end"><strong>{{ number_format($ct->Thanh_Tien, 0, ',', '.') }}₫</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-end"><strong>Tổng tiền hàng:</strong></td>
                                    <td class="text-end"><strong>{{ number_format($donHang->Tong_Tien, 0, ',', '.') }}₫</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                    <td class="text-end"><strong>{{ number_format($donHang->Phi_Van_Chuyen, 0, ',', '.') }}₫</strong></td>
                                </tr>
                                <tr class="table-warning">
                                    <td colspan="6" class="text-end"><strong>TỔNG THANH TOÁN:</strong></td>
                                    <td class="text-end">
                                        <strong class="text-danger fs-5">
                                            {{ number_format($donHang->Tien_Thanh_Toan, 0, ',', '.') }}₫
                                        </strong>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="6" class="text-end text-muted fst-italic">
                                        <small>Lợi nhuận ước tính (Giá bán - Giá vốn):</small>
                                    </td>
                                    <td class="text-end text-success fw-bold">
                                        @php
                                            $tongVon = 0;
                                            foreach($donHang->chiTietDonHangs as $ct) {
                                                // Lấy giá nhập từ bảng Sản phẩm thông qua quan hệ
                                                // Lưu ý: Nếu sản phẩm bị xóa thì lấy mặc định = 0
                                                $giaNhap = $ct->bienTheSanPham->sanPham->Gia_Nhap ?? 0; 
                                                $tongVon += $giaNhap * $ct->So_Luong;
                                            }
                                            $lai = $donHang->Tong_Tien - $tongVon;
                                        @endphp
                                        +{{ number_format($lai, 0, ',', '.') }}₫
                                    </td>
                                </tr>                                

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">⚙️ Quản lý đơn hàng</h5>
                </div>
                <div class="card-body">
                    @if(!in_array($donHang->Trang_Thai, ['Hoan_Thanh', 'Huy']))
                        <form action="{{ route('admin.donhang.updateStatus', $donHang->Ma_Don_Hang) }}" 
                              method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label"><strong>Cập nhật trạng thái:</strong></label>
                                <select name="Trang_Thai" class="form-select" required>
                                    <option value="">-- Chọn trạng thái --</option>
                                    <option value="Cho_Xac_Nhan" {{ $donHang->Trang_Thai == 'Cho_Xac_Nhan' ? 'selected' : '' }}>
                                        Chờ xác nhận
                                    </option>
                                    <option value="Da_Xac_Nhan" {{ $donHang->Trang_Thai == 'Da_Xac_Nhan' ? 'selected' : '' }}>
                                        Đã xác nhận
                                    </option>
                                    <option value="Dang_Giao" {{ $donHang->Trang_Thai == 'Dang_Giao' ? 'selected' : '' }}>
                                        Đang giao
                                    </option>
                                    <option value="Hoan_Thanh" {{ $donHang->Trang_Thai == 'Hoan_Thanh' ? 'selected' : '' }}>
                                        Hoàn thành
                                    </option>
                                    <option value="Huy" {{ $donHang->Trang_Thai == 'Huy' ? 'selected' : '' }}>
                                        Hủy đơn
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-check-circle"></i> Cập nhật
                            </button>
                        </form>
                    @else
                        <div class="alert alert-info mb-0">
                            <strong>Lưu ý:</strong> Đơn hàng đã {{ $donHang->Trang_Thai == 'Hoan_Thanh' ? 'hoàn thành' : 'bị hủy' }}, không thể thay đổi trạng thái!
                        </div>
                    @endif

                    @if($donHang->Trang_Thai === 'Huy')
                        <hr>
                        <form action="{{ route('admin.donhang.destroy', $donHang->Ma_Don_Hang) }}"
                              method="POST"
                              onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-trash"></i> Xóa đơn hàng
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection