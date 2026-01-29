<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin - QuanAoBongDa</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg border-0" style="width: 400px;">
            
            <div class="card-header text-center bg-dark text-white">
                <h4 class="mb-0">
                    <i class="bi bi-shield-lock"></i> Admin Login
                </h4>
            </div>

            <div class="card-body p-4">

                {{-- Hiển thị lỗi validate / login --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf

                    <!-- Tài khoản -->
                    <div class="mb-3">
                        <label class="form-label">Tài khoản</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text"
                                   name="Tai_Khoan"
                                   class="form-control"
                                   value="{{ old('Tai_Khoan') }}"
                                   placeholder="Nhập tài khoản"
                                   required>
                        </div>
                    </div>

                    <!-- Mật khẩu -->
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password"
                                   name="Mat_Khau"
                                   class="form-control"
                                   placeholder="Nhập mật khẩu"
                                   required>
                        </div>
                    </div>

                    <!-- Ghi nhớ đăng nhập -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>

                    <!-- Nút đăng nhập -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-box-arrow-in-right"></i> Đăng nhập
                        </button>
                    </div>

                </form>
            </div>

            <div class="card-footer text-center text-muted small">
                © {{ date('Y') }} QuanAoBongDa
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
