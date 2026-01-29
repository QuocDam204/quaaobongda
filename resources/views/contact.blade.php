@extends('layouts.customer.app')

@section('title', 'Liên hệ - Shop Bóng Đá')

@section('content')

{{-- Header Banner --}}
<section class="bg-navy text-white text-center py-5 position-relative overflow-hidden">
    <div class="container py-4">
        <h1 class="display-4 fw-bold text-uppercase font-sport mb-3" style="letter-spacing: 2px;">
            Liên Hệ Với Chúng Tôi
        </h1>
        <p class="lead opacity-75">Đội ngũ Shop Bóng Đá luôn sẵn sàng lắng nghe và hỗ trợ bạn 24/7</p>
    </div>
    
    {{-- Decorative wave --}}
    <div class="position-absolute bottom-0 start-0 w-100" style="height: 50px; background: #f8f9fa; transform: skewY(-1.5deg); transform-origin: top left;"></div>
</section>

{{-- Thông tin liên hệ --}}
<div class="container" style="margin-top: -30px; position: relative; z-index: 2;">
    <div class="row g-4 mb-5">
        {{-- Địa chỉ --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-4 hover-card border-top border-4 border-primary">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 70px; height: 70px;">
                    <i class="bi bi-geo-alt-fill text-primary fs-2"></i>
                </div>
                <h5 class="fw-bold text-uppercase mb-3">Địa Chỉ Cửa Hàng</h5>
                <p class="text-muted mb-1">123 Ấp Nước Mặn, Xã Hưng Hội</p>
                <p class="text-muted mb-3">Tỉnh Cà Mau, Việt Nam</p>
            </div>
        </div>
        
        {{-- Hotline --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-4 hover-card border-top border-4 border-success">
                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 70px; height: 70px;">
                    <i class="bi bi-telephone-fill text-success fs-2"></i>
                </div>
                <h5 class="fw-bold text-uppercase mb-3">Hotline Hỗ Trợ</h5>
                <p class="fw-bold fs-4 mb-1 text-dark">02943855375</p>
                <p class="text-muted small mb-3">8:00 - 22:00 (Cả CN & Lễ)</p>
                <a href="tel:02943855375" class="btn btn-outline-success btn-sm rounded-pill">
                    <i class="bi bi-telephone me-1"></i> Gọi ngay
                </a>
            </div>
        </div>

        {{-- Email --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-4 hover-card border-top border-4 border-danger">
                <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 70px; height: 70px;">
                    <i class="bi bi-envelope-open-fill text-danger fs-2"></i>
                </div>
                <h5 class="fw-bold text-uppercase mb-3">Email Hợp Tác</h5>
                <p class="mb-1">
                    <a href="mailto:support@shopbongda.com" class="text-decoration-none text-dark fw-bold">
                        support@shopbongda.com
                    </a>
                </p>
                <p class="text-muted small mb-0">Phản hồi trong 24h làm việc</p>
            </div>
        </div>
    </div>

    {{-- FAQ & Social --}}
    <div class="row mb-5 justify-content-center">
        <div class="col-lg-8">
            {{-- FAQ Section --}}
            <div class="mb-4">
                <h3 class="fw-bold text-uppercase text-center mb-4 font-sport">
                    Câu Hỏi Thường Gặp
                </h3>
                
                <div class="accordion shadow-sm rounded-3 overflow-hidden" id="faqAccordion">
                    {{-- FAQ 1 --}}
                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="bi bi-patch-check me-2 text-primary"></i>
                                Shop có bán hàng chính hãng không?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body bg-light">
                                <p class="text-muted mb-0">
                                    Cam kết 100% sản phẩm chính hãng (Authentic) và hàng Thái cao cấp (Rep 1:1). 
                                    Chúng tôi luôn ghi rõ nguồn gốc trong mô tả từng sản phẩm.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- FAQ 2 --}}
                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <i class="bi bi-truck me-2 text-success"></i>
                                Thời gian giao hàng bao lâu?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body bg-light">
                                <ul class="text-muted mb-0 ps-3">
                                    <li>Nội thành HCM: 1-2 ngày</li>
                                    <li>Các tỉnh thành khác: 2-4 ngày làm việc</li>
                                    <li>Hỗ trợ Ship hỏa tốc Grab/Ahamove trong ngày</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    {{-- FAQ 3 --}}
                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <i class="bi bi-arrow-repeat me-2 text-warning"></i>
                                Chính sách đổi trả như thế nào?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body bg-light">
                                <p class="text-muted mb-0">
                                    Đổi trả miễn phí trong vòng 7 ngày nếu lỗi nhà sản xuất, giao sai mẫu 
                                    hoặc không vừa size (sản phẩm còn nguyên tem mác).
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- FAQ 4 --}}
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                <i class="bi bi-credit-card me-2 text-info"></i>
                                Có những hình thức thanh toán nào?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body bg-light">
                                <ul class="text-muted mb-0 ps-3">
                                    <li>COD - Thanh toán khi nhận hàng</li>
                                    <li>Chuyển khoản ngân hàng</li>
                                    <li>Ví điện tử: Momo, ZaloPay</li>
                                    <li>Thẻ ATM/Visa/Mastercard</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Social Media --}}
            <div class="card border-0 shadow-sm p-4 text-center">
                <h5 class="fw-bold mb-3 text-uppercase font-sport">Kết Nối Với Chúng Tôi</h5>
                <p class="text-muted small mb-3">Theo dõi để cập nhật sản phẩm mới & ưu đãi hot</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="#" class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center" 
                       style="width: 50px; height: 50px;" title="Facebook">
                        <i class="bi bi-facebook fs-5"></i>
                    </a>
                    <a href="#" class="btn btn-outline-danger rounded-circle d-flex align-items-center justify-content-center" 
                       style="width: 50px; height: 50px;" title="Instagram">
                        <i class="bi bi-instagram fs-5"></i>
                    </a>
                    <a href="#" class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" 
                       style="width: 50px; height: 50px;" title="TikTok">
                        <i class="bi bi-tiktok fs-5"></i>
                    </a>
                    <a href="#" class="btn btn-outline-danger rounded-circle d-flex align-items-center justify-content-center" 
                       style="width: 50px; height: 50px;" title="YouTube">
                        <i class="bi bi-youtube fs-5"></i>
                    </a>
                    <a href="#" class="btn btn-outline-success rounded-circle d-flex align-items-center justify-content-center" 
                       style="width: 50px; height: 50px;" title="Zalo">
                        <i class="bi bi-chat-dots-fill fs-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CTA Section --}}
<section class="bg-primary bg-opacity-10 py-5">
    <div class="container text-center">
        <h3 class="fw-bold mb-3 font-sport">BẠN CÒN THẮC MẮC?</h3>
        <p class="text-muted mb-4">Đội ngũ tư vấn chuyên nghiệp sẵn sàng hỗ trợ bạn mọi lúc</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="tel:0123456789" class="btn btn-primary btn-lg rounded-pill px-4">
                <i class="bi bi-telephone-fill me-2"></i> Gọi Hotline
            </a>
            <a href="mailto:support@shopbongda.com" class="btn btn-outline-primary btn-lg rounded-pill px-4">
                <i class="bi bi-envelope-fill me-2"></i> Gửi Email
            </a>
        </div>
    </div>
</section>

@endsection