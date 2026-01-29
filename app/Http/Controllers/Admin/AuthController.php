<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'Tai_Khoan' => 'required|string',
            'Mat_Khau'  => 'required|string',
        ], [
            'Tai_Khoan.required' => 'Vui lòng nhập tài khoản',
            'Mat_Khau.required' => 'Vui lòng nhập mật khẩu',
        ]);

        $user = \App\Models\QuanTriVien::where('Tai_Khoan', $request->Tai_Khoan)->first();

        if (!$user) {
            return back()
                ->withInput($request->only('Tai_Khoan'))
                ->withErrors(['login_error' => 'Tài khoản không tồn tại!']);
        }

        if (!Hash::check($request->Mat_Khau, $user->Mat_Khau)) {
            return back()
                ->withInput($request->only('Tai_Khoan'))
                ->withErrors(['login_error' => 'Mật khẩu không đúng!']);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Đăng nhập thành công!');
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')
            ->with('success', 'Đã đăng xuất thành công!');
    }

    // Hiển thị trang dashboard
    public function dashboard()
    {
        $admin = Auth::user();
        return view('admin.dashboard', compact('admin'));
    }
}