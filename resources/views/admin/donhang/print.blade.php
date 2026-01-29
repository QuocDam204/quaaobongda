<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In đơn hàng #{{ $donHang->Ma_Don_Hang }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 14px; }
        .invoice-header { border-bottom: 2px solid #000; margin-bottom: 20px; padding-bottom: 10px; }
        .invoice-title { font-weight: bold; font-size: 24px; text-transform: uppercase; }
        .table th { background-color: #f8f9fa !important; color: #000; }
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="container mt-4">
        <div class="mb-4 no-print">
            <a href="{{ route('admin.donhang.show', $donHang->Ma_Don_Hang) }}" class="btn btn-secondary">
                &laquo; Quay lại
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                In hóa đơn
            </button>
        </div>

        <div class="card border-0">
            <div class="card-body">
                <div class="row invoice-header">
                    <div class="col-6">
                        <h4 class="invoice-title">HÓA ĐƠN BÁN HÀNG</h4>
                        <p>Mã đơn hàng: <strong>#{{ $donHang->Ma_Don_Hang }}</strong></p>
                        <p>Ngày đặt: {{ $donHang->Ngay_Dat->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <h5>CỬA HÀNG QUẦN ÁO BÓNG ĐÁ</h5>
                        <p>Địa chỉ: 123 Đường ABC, Quận XYZ, TP.HCM</p>
                        <p>Hotline: 0901234567</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h6>THÔNG TIN NGƯỜI NHẬN</h6>
                        <ul class="list-unstyled">
                            <li><strong>Họ tên:</strong> {{ $donHang->Ho_Ten_Nguoi_Nhan }}</li>
                            <li><strong>Số điện thoại:</strong> {{ $donHang->So_Dien_Thoai_Nguoi_Nhan }}</li>
                            <li><strong>Địa chỉ:</strong> {{ $donHang->Dia_Chi_Giao }}</li>
                            @if($donHang->Ghi_Chu)
                                <li><strong>Ghi chú:</strong> {{ $donHang->Ghi_Chu }}</li>
                            @endif
                        </ul>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">STT</th>
                            <th>Sản phẩm</th>
                            <th class="text-center">Kích cỡ</th>
                            <th class="text-center">Màu</th>
                            <th>Thông tin in</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Đơn giá</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donHang->chiTietDonHangs as $index => $ct)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    {{-- ĐÃ SỬA: bienThe -> bienTheSanPham --}}
                                    <strong>{{ $ct->bienTheSanPham->sanPham->Ten_San_Pham ?? 'Sản phẩm đã xóa' }}</strong>
                                    <br>
                                    <small class="text-muted">SKU: {{ $ct->bienTheSanPham->SKU ?? 'N/A' }}</small>
                                </td>
                                <td class="text-center">{{ $ct->bienTheSanPham->size->Ten_Size ?? '-' }}</td>
                                <td class="text-center">{{ $ct->bienTheSanPham->Mau_Sac ?? '-' }}</td>
                                <td>
                                    @if($ct->Ten_In_Ao || $ct->So_In_Ao)
                                        <small>
                                            {{ $ct->Ten_In_Ao ?? '' }}
                                            @if($ct->So_In_Ao)
                                                <br>Số: {{ $ct->So_In_Ao }}
                                            @endif
                                        </small>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">{{ $ct->So_Luong }}</td>
                                <td class="text-end">{{ number_format($ct->Gia_Ban, 0, ',', '.') }}₫</td>
                                <td class="text-end">{{ number_format($ct->Thanh_Tien, 0, ',', '.') }}₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" class="text-end">Tổng tiền hàng:</td>
                            <td class="text-end fw-bold">{{ number_format($donHang->Tong_Tien, 0, ',', '.') }}₫</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-end">Phí vận chuyển:</td>
                            <td class="text-end fw-bold">{{ number_format($donHang->Phi_Van_Chuyen, 0, ',', '.') }}₫</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-end text-uppercase fw-bold">Tổng thanh toán:</td>
                            <td class="text-end fw-bold fs-5">{{ number_format($donHang->Tien_Thanh_Toan, 0, ',', '.') }}₫</td>
                        </tr>
                    </tfoot>
                </table>

                <div class="row mt-5">
                    <div class="col-6 text-center">
                        <p><strong>Người lập phiếu</strong></p>
                        <p class="fst-italic">(Ký, họ tên)</p>
                    </div>
                    <div class="col-6 text-center">
                        <p><strong>Người nhận hàng</strong></p>
                        <p class="fst-italic">(Ký, họ tên)</p>
                    </div>
                </div>
                
                <div class="text-center mt-4 fst-italic no-print">
                    <small>Cảm ơn quý khách đã mua hàng!</small>
                </div>
            </div>
        </div>
    </div>

</body>
</html>