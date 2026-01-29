<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shop Quần Áo Bóng Đá')</title>

    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* Font & Body */
        .font-sport { font-family: 'Oswald', sans-serif; text-transform: uppercase; }
        body { font-family: 'Roboto', sans-serif; padding-top: 130px; }

        /* Màu thương hiệu */
        .bg-navy { background-color: #0f172a; }
        .text-navy { color: #0f172a; }
        .text-accent { color: #ff5722; }
        
        /* Hover effects */
        .hover-card { transition: transform 0.2s, box-shadow 0.2s; }
        .hover-card:hover { transform: translateY(-5px); box-shadow: 0 0.625rem 1.25rem rgba(0,0,0,0.1) !important; }
        .nav-link.active { color: #ff5722 !important; font-weight: bold; }
        
        @stack('styles')
    </style>
</head>
<body>

    {{-- Top Bar --}}
    <nav class="bg-navy text-white fixed-top py-2" style="height: 40px; z-index: 1040;">
        <div class="container d-flex justify-content-between align-items-center small">
            <div>
                <span class="me-3"><i class="bi bi-telephone-fill me-1"></i> 0294.385.5375</span>
                <span class="d-none d-md-inline"><i class="bi bi-envelope-fill me-1"></i> hotro@shopbongda.com</span>
            </div>
        </div>
    </nav>

    {{-- Main Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top" style="top: 40px;">
        <div class="container">
            <a class="navbar-brand font-sport fw-bold fs-3 text-navy" href="{{ route('home') }}">
                <i class="bi bi-trophy-fill text-warning me-1"></i>SHOP BÓNG ĐÁ
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-bold text-uppercase" style="font-size: 0.9rem;">
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('home') ? 'active' : '' }}" 
                           href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('products.*') ? 'active' : '' }}" 
                           href="{{ route('products.index') }}">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('about') ? 'active' : '' }}" 
                           href="{{ route('about') }}">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('contact') ? 'active' : '' }}" 
                           href="{{ route('contact') }}">Liên hệ</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-2">
                    {{-- Desktop Search Form --}}
                    <form class="d-none d-lg-block" action="{{ route('products.index') }}" method="GET">
                        <div class="input-group input-group-sm">
                            <input class="form-control border-end-0" 
                                   type="search" 
                                   name="search" 
                                   placeholder="Tìm kiếm sản phẩm..." 
                                   value="{{ request('search') }}"
                                   style="width: 200px;">
                            <button class="btn btn-outline-secondary border-start-0 bg-white" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                    
                    {{-- Mobile Search Button --}}
                    <button class="btn btn-link text-dark p-2 d-lg-none" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#mobileSearch">
                        <i class="bi bi-search fs-5"></i>
                    </button>
                    
                    {{-- Cart Button --}}
                    <a href="{{ route('cart.index') }}" 
                       class="btn btn-link text-dark p-2 position-relative">
                        <i class="bi bi-bag-fill fs-5"></i>
                        @php 
                            $cartCount = class_exists('App\Http\Controllers\CartController') 
                                ? App\Http\Controllers\CartController::count() 
                                : 0; 
                        @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                                  style="font-size: 0.65rem;">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
        
        {{-- Mobile Search Collapse --}}
        <div class="collapse d-lg-none border-top" id="mobileSearch">
            <div class="container py-3">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="input-group">
                        <input class="form-control" 
                               type="search" 
                               name="search" 
                               placeholder="Tìm kiếm sản phẩm..." 
                               value="{{ request('search') }}"
                               autofocus>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search me-1"></i> Tìm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main style="min-height: 60vh;">
        {{-- Flash Messages --}}
        @if(session('success') || session('error'))
        <div class="container mt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> 
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-navy text-light pt-5 pb-3 mt-5 border-top border-4 border-warning">
        <div class="container">
            <div class="row g-4">
                {{-- About Column --}}
                <div class="col-lg-4 col-md-6">
                    <h5 class="font-sport text-warning mb-3">SHOP BÓNG ĐÁ</h5>
                    <p class="small text-light opacity-75">
                        Chuyên cung cấp quần áo bóng đá CLB, đội tuyển chất lượng cao, 
                        in ấn chuyên nghiệp lấy ngay.
                    </p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="text-light fs-5 opacity-75" style="transition: opacity 0.2s;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="text-light fs-5 opacity-75" style="transition: opacity 0.2s;">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="#" class="text-light fs-5 opacity-75" style="transition: opacity 0.2s;">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
                
                {{-- Policy Column --}}
                <div class="col-lg-2 col-md-6">
                    <h6 class="font-sport text-white mb-3">CHÍNH SÁCH</h6>
                    <ul class="list-unstyled small opacity-75">
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none text-light">
                                <i class="bi bi-chevron-right me-1 text-warning"></i>Đổi trả hàng
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none text-light">
                                <i class="bi bi-chevron-right me-1 text-warning"></i>Bảo mật thông tin
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none text-light">
                                <i class="bi bi-chevron-right me-1 text-warning"></i>Kiểm tra đơn hàng
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Contact Column --}}
                <div class="col-lg-3 col-md-6">
                    <h6 class="font-sport text-white mb-3">LIÊN HỆ</h6>
                    <ul class="list-unstyled small opacity-75">
                        <li class="mb-2">
                            <i class="bi bi-geo-alt-fill me-2 text-warning"></i> 
                            123 Đường Sân Cỏ, Hà Nội
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-telephone-fill me-2 text-warning"></i> 
                            0912.345.678
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope-fill me-2 text-warning"></i> 
                            cskh@shopbongda.com
                        </li>
                    </ul>
                </div>
                
                {{-- Quick Links Column --}}
                <div class="col-lg-3 col-md-6">
                    <h6 class="font-sport text-white mb-3">LIÊN KẾT</h6>
                    <ul class="list-unstyled small opacity-75">
                        <li class="mb-2">
                            <a href="{{ route('home') }}" class="text-decoration-none text-light">
                                <i class="bi bi-chevron-right me-1 text-warning"></i>Trang chủ
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('products.index') }}" class="text-decoration-none text-light">
                                <i class="bi bi-chevron-right me-1 text-warning"></i>Sản phẩm
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('about') }}" class="text-decoration-none text-light">
                                <i class="bi bi-chevron-right me-1 text-warning"></i>Giới thiệu
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('contact') }}" class="text-decoration-none text-light">
                                <i class="bi bi-chevron-right me-1 text-warning"></i>Liên hệ
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="border-secondary opacity-25 my-4">
            
            <div class="text-center small opacity-50">
                &copy; 2024 Shop Bóng Đá. All rights reserved.
            </div>
        </div>
    </footer>

    {{-- Back to Top Button --}}
    <button class="btn btn-warning rounded-circle position-fixed bottom-0 end-0 m-4 shadow" 
            id="backToTop" 
            style="width: 50px; height: 50px; display: none; z-index: 1000;">
        <i class="bi bi-arrow-up-short fs-4"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Back to top button
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTop.style.display = 'block';
            } else {
                backToTop.style.display = 'none';
            }
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        
        // Auto dismiss alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>