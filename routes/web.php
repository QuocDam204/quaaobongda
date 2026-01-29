<?php

use Illuminate\Support\Facades\Route;

// --- Admin Controllers ---
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\Admin\ThuongHieuController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\BienTheSanPhamController;
use App\Http\Controllers\Admin\DonHangController;

// --- Customer Controllers ---
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| FRONTEND - KHÁCH HÀNG
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/gioi-thieu', [HomeController::class, 'about'])->name('about');
Route::get('/lien-he', [HomeController::class, 'contact'])->name('contact');

Route::get('/san-pham', [HomeController::class, 'products'])->name('products.index');
Route::get('/san-pham/{id}', [HomeController::class, 'productDetail'])->name('products.detail');

Route::prefix('gio-hang')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/{cartKey}', [CartController::class, 'update'])->name('update');
    Route::delete('/{cartKey}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

Route::prefix('thanh-toan')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('process');
    Route::get('/thanh-cong/{maDonHang}', [CheckoutController::class, 'success'])->name('success');
});

/*
|--------------------------------------------------------------------------
| BACKEND - ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    
    // --- GUEST ---
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    });

    // --- AUTH ---
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        
        Route::resource('danhmuc', DanhMucController::class);
        Route::resource('thuonghieu', ThuongHieuController::class);
        Route::resource('size', SizeController::class);
        Route::resource('sanpham', SanPhamController::class);
        
        // Ảnh sản phẩm
        Route::delete('sanpham/{sanpham}/image/{image}', [SanPhamController::class, 'deleteImage'])->name('sanpham.deleteImage');
        Route::post('sanpham/{sanpham}/image/{image}/main', [SanPhamController::class, 'setMainImage'])->name('sanpham.setMainImage');
        
        // Biến thể
        Route::prefix('sanpham/{sanpham}/bienthe')->name('bienthe.')->group(function () {
            Route::get('/', [BienTheSanPhamController::class, 'index'])->name('index');
            Route::get('/create', [BienTheSanPhamController::class, 'create'])->name('create');
            Route::post('/', [BienTheSanPhamController::class, 'store'])->name('store');
            Route::get('/{bienthe}/edit', [BienTheSanPhamController::class, 'edit'])->name('edit');
            Route::put('/{bienthe}', [BienTheSanPhamController::class, 'update'])->name('update');
            Route::delete('/{bienthe}', [BienTheSanPhamController::class, 'destroy'])->name('destroy');
        });
        Route::post('bienthe/{bienthe}/update-stock', [BienTheSanPhamController::class, 'updateStock'])->name('bienthe.updateStock');
        
        // --- QUẢN LÝ ĐƠN HÀNG ---
        Route::resource('donhang', DonHangController::class)->except(['edit', 'update', 'create', 'store']);
        
        // Các route tùy chỉnh cho đơn hàng
        Route::get('donhang/{donhang}/edit', [DonHangController::class, 'edit'])->name('donhang.edit');
        Route::put('donhang/{donhang}', [DonHangController::class, 'update'])->name('donhang.update');
        Route::post('donhang/{donhang}/status', [DonHangController::class, 'updateStatus'])->name('donhang.updateStatus');
        Route::get('thong-ke/donhang', [DonHangController::class, 'statistics'])->name('donhang.statistics');
        
        // --- ROUTE IN ĐƠN HÀNG (MỚI THÊM) ---
        // Lưu ý: Đặt tên là 'donhang.print' thì khi gọi route sẽ là 'admin.donhang.print' (do prefix group)
        Route::get('donhang/{id}/print', [DonHangController::class, 'print'])->name('donhang.print');
        
        // Route Export Excel (nếu cần dùng sau này)
        Route::get('donhang/export/excel', [DonHangController::class, 'exportExcel'])->name('donhang.export.excel');
    });
});