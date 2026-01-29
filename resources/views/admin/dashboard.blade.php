@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
{{-- CSS tạo hiệu ứng hover và giao diện thẻ --}}
<style>
    .admin-card {
        border: none;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        transition: 0.3s;
    }
    .action-card {
        text-decoration: none;
        color: #495057;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 30px 15px;
        height: 100%;
        border: 1px solid #f1f3f5;
        border-radius: 15px;
        background: #fff;
        transition: all 0.3s ease;
    }
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        border-color: #0d6efd;
        color: #0d6efd;
    }
    .action-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }
    .profile-header {
        background: linear-gradient(135deg, #0d6efd, #0dcaf0);
        color: white;
        padding: 30px;
        border-radius: 15px 15px 0 0;
        text-align: center;
    }
</style>

<div class="container my-5">
    <div class="row g-4">
        
        {{-- CỘT 1: THÔNG TIN ADMIN (Profile) --}}
        <div class="col-md-4">
            <div class="card admin-card h-100">
                <div class="profile-header">
                    <h4 class="fw-bold mb-0">{{ $admin->Ho_Ten }}</h4>
                </div>
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted small fw-bold mb-3">Thông tin tài khoản</h6>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3 text-primary"><i class="bi bi-person-badge fs-4"></i></div>
                        <div>
                            <small class="text-muted d-block">Tài khoản</small>
                            <strong>{{ $admin->Tai_Khoan }}</strong>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3 text-success"><i class="bi bi-envelope fs-4"></i></div>
                        <div>
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $admin->Email }}</strong>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="me-3 text-warning"><i class="bi bi-telephone fs-4"></i></div>
                        <div>
                            <small class="text-muted d-block">Số điện thoại</small>
                            <strong>{{ $admin->So_Dien_Thoai }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CỘT 2: CHỨC NĂNG QUẢN LÝ (Menu Icon) --}}
        <div class="col-md-8">
            <h4 class="mb-4 fw-bold text-secondary"><i class="bi bi-grid-fill me-2"></i>Chức Năng Quản Lý</h4>
            
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
                <div class="col">
                    <a href="{{ route('admin.donhang.index') }}" class="action-card">
                        <i class="bi bi-cart-check-fill action-icon text-primary"></i>
                        <h6 class="fw-bold m-0">Đơn Hàng</h6>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('admin.sanpham.index') }}" class="action-card">
                        <i class="bi bi-box-seam-fill action-icon text-success"></i>
                        <h6 class="fw-bold m-0">Sản Phẩm</h6>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('admin.danhmuc.index') }}" class="action-card">
                        <i class="bi bi-folder2-open action-icon text-warning"></i>
                        <h6 class="fw-bold m-0">Danh Mục</h6>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('admin.thuonghieu.index') }}" class="action-card">
                        <i class="bi bi-tags-fill action-icon text-danger"></i>
                        <h6 class="fw-bold m-0">Thương Hiệu</h6>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('admin.size.index') }}" class="action-card">
                        <i class="bi bi-aspect-ratio-fill action-icon text-info"></i>
                        <h6 class="fw-bold m-0">Kích cỡ</h6>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection