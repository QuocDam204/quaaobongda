@extends('layouts.customer.app')

@section('title', 'Thanh toán')

@section('content')
<div class="container my-5">
    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
            <li class="breadcrumb-item active">Thanh toán</li>
        </ol>
    </nav>

    <h2 class="mb-4 text-center fw-bold">THÔNG TIN THANH TOÁN</h2>

    {{-- Hiển thị thông báo lỗi nếu có --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-person-lines-fill text-primary"></i> Thông tin người nhận</h5>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('Ho_Ten_Nguoi_Nhan') is-invalid @enderror" 
                                   name="Ho_Ten_Nguoi_Nhan" 
                                   value="{{ old('Ho_Ten_Nguoi_Nhan') }}" 
                                   placeholder="Nhập họ tên người nhận">
                            @error('Ho_Ten_Nguoi_Nhan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('So_Dien_Thoai_Nguoi_Nhan') is-invalid @enderror" 
                                       name="So_Dien_Thoai_Nguoi_Nhan" 
                                       value="{{ old('So_Dien_Thoai_Nguoi_Nhan') }}" 
                                       placeholder="VD: 0987654321">
                                @error('So_Dien_Thoai_Nguoi_Nhan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email (Tùy chọn)</label>
                                <input type="email" 
                                       class="form-control @error('Email_Nguoi_Nhan') is-invalid @enderror" 
                                       name="Email_Nguoi_Nhan" 
                                       value="{{ old('Email_Nguoi_Nhan') }}" 
                                       placeholder="email@example.com">
                                @error('Email_Nguoi_Nhan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('Dia_Chi_Giao') is-invalid @enderror" 
                                      name="Dia_Chi_Giao" 
                                      rows="3" 
                                      placeholder="Số nhà, tên đường, phường/xã, quận/huyện...">{{ old('Dia_Chi_Giao') }}</textarea>
                            @error('Dia_Chi_Giao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Ghi chú đơn hàng</label>
                            <textarea class="form-control" name="Ghi_Chu" rows="2" placeholder="VD: Giao hàng giờ hành chính...">{{ old('Ghi_Chu') }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-cart-check text-primary"></i> Đơn hàng của bạn</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @php $tongTien = 0; @endphp
                            @foreach($cart as $item)
                                @php 
                                    $thanhTien = $item['Gia_Ban'] * $item['So_Luong'];
                                    $tongTien += $thanhTien;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <h6 class="mb-0 text-truncate" style="max-width: 150px;">{{ $item['Ten_San_Pham'] }}</h6>
                                            <small class="text-muted d-block">
                                                Size: {{ $item['Size'] }} | Màu: {{ $item['Mau_Sac'] }} 
                                            </small>
                                            <small class="text-muted">x {{ $item['So_Luong'] }}</small>
                                        </div>
                                    </div>
                                    <span class="fw-bold">{{ number_format($thanhTien, 0, ',', '.') }}đ</span>
                                </li>
                            @endforeach
                            
                            <li class="list-group-item d-flex justify-content-between bg-light">
                                <span>Tạm tính</span>
                                <strong>{{ number_format($tongTien, 0, ',', '.') }}đ</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-light">
                                <span>Phí vận chuyển</span>
                                <strong>30.000đ</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-primary text-white fs-5 fw-bold">
                                <span>TỔNG CỘNG</span>
                                <span>{{ number_format($tongTien + 30000, 0, ',', '.') }}đ</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-wallet2 text-primary"></i> Phương thức thanh toán</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="Phuong_Thuc_Thanh_Toan" id="paymentCOD" value="COD" checked>
                            <label class="form-check-label fw-bold" for="paymentCOD">
                                Thanh toán khi nhận hàng (COD)
                            </label>
                            <div class="text-muted small ms-4">
                                Bạn sẽ thanh toán tiền mặt cho shipper khi nhận được hàng.
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="Phuong_Thuc_Thanh_Toan" id="paymentBanking" value="Chuyen_Khoan">
                            <label class="form-check-label fw-bold" for="paymentBanking">
                                Chuyển khoản ngân hàng
                            </label>
                            <div class="text-muted small ms-4">
                                Thông tin tài khoản sẽ hiện ra sau khi bạn đặt hàng.
                            </div>
                        </div>
                        @error('Phuong_Thuc_Thanh_Toan')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-danger btn-lg w-100 py-3 fw-bold text-uppercase">
                    Xác nhận đặt hàng
                </button>
                <div class="text-center mt-3">
                    <a href="{{ route('cart.index') }}" class="text-decoration-none">
                        <i class="bi bi-arrow-left"></i> Quay lại giỏ hàng
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection