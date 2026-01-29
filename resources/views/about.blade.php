@extends('layouts.customer.app')

@section('title', 'Về Chúng Tôi - Shop Bóng Đá')

@section('content')

{{-- Hero Banner --}}
<section class="position-relative bg-dark text-white text-center py-5" style="min-height: 400px; background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.7)), url('https://images.unsplash.com/photo-1522778119026-d647f0565c6a?q=80&w=1920') center/cover;">
    <div class="container d-flex flex-column justify-content-center align-items-center h-100 py-5">
        <h1 class="display-3 fw-bold text-uppercase mb-3 font-sport" style="letter-spacing: 3px;">
            Câu Chuyện Của Chúng Tôi
        </h1>
        <p class="lead opacity-75 mb-4 mx-auto" style="max-width: 700px;">
            Nơi đam mê bóng đá gặp gỡ phong cách thời thượng. Chúng tôi không chỉ bán áo đấu, chúng tôi bán niềm tự hào.
        </p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0 bg-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-white-50 text-decoration-none fw-bold">TRANG CHỦ</a>
                </li>
                <li class="breadcrumb-item active text-white fw-bold">GIỚI THIỆU</li>
            </ol>
        </nav>
    </div>
</section>

{{-- Câu chuyện --}}
<div class="container py-5 my-4">
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?q=80&w=1000" 
                     class="img-fluid rounded-4 shadow-lg" 
                     alt="Shop Bóng Đá Story">
                
                <div class="position-absolute bottom-0 start-0 bg-white p-4 rounded-3 shadow-lg m-3 border-start border-4 border-danger">
                    <h2 class="fw-bold mb-0">2024</h2>
                    <small class="text-muted fw-bold text-uppercase">Năm thành lập</small>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-4">
                <h2 class="fw-bold font-sport text-uppercase mb-3">Khơi Nguồn Đam Mê</h2>
                <div class="bg-danger" style="width: 60px; height: 4px;"></div>
            </div>
            
            <p class="lead fw-bold fst-italic text-dark mb-4">
                "Bóng đá không chỉ là môn thể thao, đó là tín ngưỡng."
            </p>
            
            <p class="text-muted">
                Xuất phát từ tình yêu mãnh liệt với trái bóng tròn, <strong>Shop Bóng Đá</strong> ra đời với sứ mệnh kết nối người hâm mộ Việt Nam với những sản phẩm thể thao chất lượng quốc tế. Chúng tôi hiểu cảm giác khoác lên mình chiếc áo của đội bóng yêu thích - đó là niềm tự hào, là sự kiêu hãnh.
            </p>
            
            <p class="text-muted mb-4">
                Trải qua hành trình phát triển, chúng tôi tự hào là điểm đến tin cậy của hàng ngàn Fan hâm mộ, cung cấp đa dạng các mẫu áo đấu từ Premier League, La Liga đến các giải đấu quốc gia.
            </p>
            
            <div class="row g-3 mb-4">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-patch-check-fill text-primary fs-4 me-3"></i>
                        <span class="fw-bold">100% Chính hãng</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-truck text-primary fs-4 me-3"></i>
                        <span class="fw-bold">Giao hàng toàn quốc</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-arrow-repeat text-primary fs-4 me-3"></i>
                        <span class="fw-bold">Đổi trả 7 ngày</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shield-lock-fill text-primary fs-4 me-3"></i>
                        <span class="fw-bold">Bảo mật tuyệt đối</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('products.index') }}" class="btn btn-dark btn-lg rounded-pill px-4 fw-bold">
                KHÁM PHÁ NGAY <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>

{{-- Thống kê --}}
<section class="bg-light py-5 border-top border-bottom">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-6 col-md-3">
                <h3 class="display-4 fw-bold text-primary mb-2 font-sport">10K+</h3>
                <p class="text-muted text-uppercase fw-bold small mb-0" style="letter-spacing: 2px;">Khách hàng</p>
            </div>
            <div class="col-6 col-md-3">
                <h3 class="display-4 fw-bold text-primary mb-2 font-sport">500+</h3>
                <p class="text-muted text-uppercase fw-bold small mb-0" style="letter-spacing: 2px;">Mẫu áo đấu</p>
            </div>
            <div class="col-6 col-md-3">
                <h3 class="display-4 fw-bold text-primary mb-2 font-sport">63</h3>
                <p class="text-muted text-uppercase fw-bold small mb-0" style="letter-spacing: 2px;">Tỉnh thành</p>
            </div>
            <div class="col-6 col-md-3">
                <h3 class="display-4 fw-bold text-primary mb-2 font-sport">4.9</h3>
                <p class="text-muted text-uppercase fw-bold small mb-0" style="letter-spacing: 2px;">Đánh giá sao</p>
            </div>
        </div>
    </div>
</section>

{{-- Giá trị cốt lõi --}}
<div class="container py-5 my-4">
    <div class="text-center mb-5 mx-auto" style="max-width: 700px;">
        <h2 class="fw-bold font-sport text-uppercase mb-3">Tại Sao Chọn Chúng Tôi?</h2>
        <div class="bg-danger mx-auto mb-3" style="width: 60px; height: 4px;"></div>
        <p class="text-muted">Chúng tôi cam kết mang lại giá trị tốt nhất cho cộng đồng yêu bóng đá.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-4 hover-card">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="bi bi-gem text-primary fs-2"></i>
                </div>
                <h5 class="fw-bold text-uppercase mb-3">Chất Lượng Vàng</h5>
                <p class="text-muted small mb-0">
                    Sản phẩm được kiểm định kỹ lưỡng, chất vải thoáng mát, co giãn, chuẩn form thi đấu chuyên nghiệp.
                </p>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-4 hover-card">
                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="bi bi-cash-coin text-success fs-2"></i>
                </div>
                <h5 class="fw-bold text-uppercase mb-3">Giá Tốt Nhất</h5>
                <p class="text-muted small mb-0">
                    Luôn có các chương trình khuyến mãi hấp dẫn, đảm bảo mức giá cạnh tranh nhất thị trường.
                </p>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-4 hover-card">
                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="bi bi-emoji-smile text-warning fs-2"></i>
                </div>
                <h5 class="fw-bold text-uppercase mb-3">Dịch Vụ Tận Tâm</h5>
                <p class="text-muted small mb-0">
                    Hỗ trợ tư vấn size, in ấn tên số theo yêu cầu. Chăm sóc khách hàng trọn đời.
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Call to Action --}}
<section class="bg-navy text-white py-5 position-relative overflow-hidden">
    <div class="container position-relative text-center py-4">
        <h2 class="fw-bold display-5 mb-3 font-sport">SẴN SÀNG RA SÂN?</h2>
        <p class="lead opacity-75 mb-4">Đừng bỏ lỡ những mẫu áo đấu mới nhất mùa giải 2024/2025</p>
        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
            <a href="{{ route('products.index') }}" class="btn btn-danger btn-lg rounded-pill px-5 fw-bold shadow">
                MUA NGAY <i class="bi bi-cart-plus ms-2"></i>
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg rounded-pill px-5 fw-bold">
                LIÊN HỆ
            </a>
        </div>
    </div>
</section>

@endsection