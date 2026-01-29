@extends('layouts.customer.app')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container my-5 text-center">
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px;">
        <div class="card-body p-5">
            <div class="mb-4 text-success">
                <i class="bi bi-check-circle-fill" style="font-size: 5rem;"></i>
            </div>
            <h2 class="fw-bold mb-3">ĐẶT HÀNG THÀNH CÔNG!</h2>
            <p class="text-muted mb-4">
                Cảm ơn bạn đã mua sắm. Mã đơn hàng của bạn là: <strong class="text-primary">#{{ $donHang->Ma_Don_Hang }}</strong>
            </p>
            
            <div class="alert alert-info text-start">
                <strong><i class="bi bi-info-circle"></i> Thông tin đơn hàng:</strong>
                <ul class="mb-0 mt-2">
                    <li>Người nhận: {{ $donHang->Ho_Ten_Nguoi_Nhan }}</li>
                    <li>Tổng tiền: {{ number_format($donHang->Tien_Thanh_Toan, 0, ',', '.') }}đ</li>
                    <li>Hình thức: {{ $donHang->Phuong_Thuc_Thanh_Toan == 'COD' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản' }}</li>
                </ul>
            </div>

            <div class="mt-4">
                <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2">
                    <i class="bi bi-house-door"></i> Về trang chủ
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4 py-2 ms-2">
                    Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
</div>
@endsection