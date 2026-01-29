@extends('layouts.customer.app')

@section('title', 'Giỏ Hàng')

@section('content')

@php
    // Lấy giỏ hàng từ Session hoặc biến truyền vào
    $cartData = isset($cart) ? $cart : session()->get('cart', []);
    $tongTien = 0;
@endphp

@push('styles')
<style>
    .cart-page { background: #f8f9fa; min-height: 80vh; padding: 50px 0; }
    .cart-card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow: hidden; }
    .cart-header { background: #fff; padding: 20px 30px; border-bottom: 1px solid #eee; }
    .img-thumb { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; border: 1px solid #eee; }
    .summary-box { background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); position: sticky; top: 100px; }
    .qty-control { display: flex; align-items: center; border: 1px solid #ddd; border-radius: 50px; width: fit-content; padding: 2px; }
    .qty-btn { border: none; background: none; width: 30px; height: 30px; border-radius: 50%; color: #555; transition: 0.2s; }
    .qty-btn:hover { background: #eee; }
    .qty-input { border: none; width: 40px; text-align: center; font-weight: bold; background: transparent; }
</style>
@endpush

<div class="cart-page">
    <div class="container">
        <h2 class="fw-bold text-uppercase mb-4">
            Giỏ Hàng <span class="text-danger">({{ count($cartData) }})</span>
        </h2>

        @if(empty($cartData))
            <div class="text-center bg-white p-5 rounded-4 shadow-sm">
                <i class="bi bi-cart-x" style="font-size: 4rem; color: #ddd;"></i>
                <h4 class="mt-4 fw-bold text-muted">Giỏ hàng trống</h4>
                <p class="text-muted mb-4">Hãy chọn thêm sản phẩm nhé!</p>
                <a href="{{ route('products.index') }}" class="btn btn-dark rounded-pill px-5 py-2 fw-bold">Mua sắm ngay</a>
            </div>
        @else
            <div class="row g-4">
                {{-- DANH SÁCH SẢN PHẨM --}}
                <div class="col-lg-8">
                    <div class="card cart-card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4 py-3">Sản phẩm</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-end pe-4">Thành tiền</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartData as $id => $item)
                                            @php
                                                $gia = $item['Gia_Ban'] ?? 0;
                                                $sl = $item['So_Luong'] ?? 1;
                                                $thanhTien = $gia * $sl;
                                                $tongTien += $thanhTien;
                                                $img = $item['Anh'] ?? '';
                                                $imgSrc = \Illuminate\Support\Str::startsWith($img, ['http', 'https']) ? $img : asset('storage/' . $img);
                                            @endphp
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $imgSrc }}" class="img-thumb" onerror="this.src='https://via.placeholder.com/80'">
                                                        <div class="ms-3">
                                                            <h6 class="mb-1 fw-bold text-dark">
                                                                <a href="{{ route('products.detail', $item['Ma_San_Pham'] ?? $id) }}" class="text-decoration-none text-dark">
                                                                    {{ $item['Ten_San_Pham'] ?? 'Sản phẩm' }}
                                                                </a>
                                                            </h6>
                                                            <small class="text-muted">Size: {{ $item['Size'] ?? 'F' }} | Màu: {{ $item['Mau_Sac'] ?? 'Gốc' }}</small>
                                                            <div class="fw-bold text-primary mt-1">{{ number_format($gia, 0, ',', '.') }}đ</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <div class="qty-control">
                                                            <button type="submit" name="action" value="decrease" class="qty-btn" onclick="this.form.querySelector('.qty-input').stepDown()">-</button>
                                                            <input type="number" name="So_Luong" value="{{ $sl }}" min="1" class="qty-input" readonly>
                                                            <button type="submit" name="action" value="increase" class="qty-btn" onclick="this.form.querySelector('.qty-input').stepUp()">+</button>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td class="text-end fw-bold text-danger pe-4">
                                                    {{ number_format($thanhTien, 0, ',', '.') }}đ
                                                </td>
                                                <td class="text-end pe-3">
                                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-sm text-muted" title="Xóa"><i class="bi bi-x-lg"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TỔNG TIỀN --}}
                <div class="col-lg-4">
                    <div class="summary-box">
                        <h5 class="fw-bold text-uppercase mb-4">Thanh Toán</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Tạm tính</span>
                            <span class="fw-bold">{{ number_format($tongTien, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 pb-3 border-bottom">
                            <span class="text-muted">Vận chuyển</span>
                            <span class="text-success fw-bold">30.000đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Tổng cộng</span>
                            <span class="fw-bold fs-4 text-danger">
                                {{ number_format($tongTien + 30000, 0, ',', '.') }}đ
                            </span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-danger w-100 py-3 rounded-pill fw-bold text-uppercase">
                            Tiến hành thanh toán
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection