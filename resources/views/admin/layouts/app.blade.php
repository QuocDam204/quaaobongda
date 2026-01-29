<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản trị hệ thống')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Màu nền xám nhẹ hiện đại */
            color: #1f2937;
        }

        /* Navbar tùy chỉnh */
        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .navbar-brand {
            font-weight: 700;
            color: #111827 !important;
            letter-spacing: -0.5px;
            font-size: 1.25rem;
        }

        .nav-link {
            font-weight: 500;
            color: #6b7280 !important; /* Màu xám trung tính */
            margin-right: 1rem;
            padding-bottom: 0.25rem;
            position: relative;
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: #111827 !important; /* Màu đen khi hover */
        }

        /* Hiệu ứng gạch chân cho mục đang Active */
        .nav-link.active {
            color: #0d6efd !important; /* Màu xanh chủ đạo */
            font-weight: 600;
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: #0d6efd;
        }

        /* Nút đăng xuất */
        .btn-logout {
            font-weight: 500;
            color: #ef4444;
            border: 1px solid #fee2e2;
            background-color: #fef2f2;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background-color: #ef4444;
            color: white;
            border-color: #ef4444;
        }

        /* Card Content */
        .main-content {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            padding: 2rem;
            min-height: 80vh;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                ADMIN STORE
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                           Tổng quan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.donhang.*') ? 'active' : '' }}" 
                           href="{{ route('admin.donhang.index') }}">
                           Đơn hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.sanpham.*', 'admin.bienthe.*') ? 'active' : '' }}" 
                           href="{{ route('admin.sanpham.index') }}">
                           Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.danhmuc.*') ? 'active' : '' }}" 
                           href="{{ route('admin.danhmuc.index') }}">
                           Danh mục
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.thuonghieu.*') ? 'active' : '' }}" 
                           href="{{ route('admin.thuonghieu.index') }}">
                           Thương hiệu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.size.*') ? 'active' : '' }}" 
                           href="{{ route('admin.size.index') }}">
                           Kích cỡ
                        </a>
                    </li>
                </ul>

                <form action="{{ route('admin.logout') }}" method="POST" class="d-flex mb-0">
                    @csrf
                    <button class="btn btn-logout btn-sm px-3 py-2 rounded-pill">
                        Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        
        {{-- Thông báo --}}
        <div class="mb-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show auto-hide shadow-sm border-0 border-start border-success border-4" role="alert">
                    <strong>Thành công!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show auto-hide shadow-sm border-0 border-start border-danger border-4" role="alert">
                    <strong>Lỗi!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <div class="main-content">
            @yield('content')
        </div>

    </div>

    <footer class="text-center py-3 text-muted small">
        &copy; {{ date('Y') }} Quản trị hệ thống. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        setTimeout(() => {
            document.querySelectorAll('.auto-hide').forEach(alert => {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 3000);
    </script>

    @stack('scripts')
</body>
</html>