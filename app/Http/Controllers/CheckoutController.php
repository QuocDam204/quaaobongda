<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\BienTheSanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Hiển thị trang thanh toán
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        return view('checkout.index', compact('cart'));
    }

    // Xử lý đặt hàng
    public function store(Request $request)
    {
        $request->validate([
            'Ho_Ten_Nguoi_Nhan' => 'required|string|max:100',
            'So_Dien_Thoai_Nguoi_Nhan' => 'required|string|max:15',
            'Email_Nguoi_Nhan' => 'nullable|email|max:100',
            'Dia_Chi_Giao' => 'required|string|max:255',
            'Ghi_Chu' => 'nullable|string',
            'Phuong_Thuc_Thanh_Toan' => 'required|in:COD,Chuyen_Khoan'
        ], [
            'Ho_Ten_Nguoi_Nhan.required' => 'Vui lòng nhập họ tên người nhận',
            'So_Dien_Thoai_Nguoi_Nhan.required' => 'Vui lòng nhập số điện thoại',
            'Dia_Chi_Giao.required' => 'Vui lòng nhập địa chỉ giao hàng',
            'Phuong_Thuc_Thanh_Toan.required' => 'Vui lòng chọn phương thức thanh toán'
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        DB::beginTransaction();
        try {
            $tongTien = 0;

            // Kiểm tra tồn kho trước khi tạo đơn
            foreach ($cart as $item) {
                $bienThe = BienTheSanPham::findOrFail($item['Ma_Bien_The']);
                
                if ($bienThe->So_Luong_Ton < $item['So_Luong']) {
                    throw new \Exception("Sản phẩm {$item['Ten_San_Pham']} (Size: {$item['Size']}, Màu: {$item['Mau_Sac']}) không đủ số lượng trong kho!");
                }
                
                $tongTien += $item['Gia_Ban'] * $item['So_Luong'];
            }

            // Phí vận chuyển cố định (có thể tùy chỉnh)
            $phiVanChuyen = 30000;
            $tienThanhToan = $tongTien + $phiVanChuyen;

            // Tạo ghi chú phương thức thanh toán
            $ghiChu = $request->Ghi_Chu ?? '';
            if ($request->Phuong_Thuc_Thanh_Toan == 'Chuyen_Khoan') {
                $ghiChu = "[CHUYỂN KHOẢN] " . $ghiChu . "\n\nKhách hàng sẽ được nhân viên liên hệ để hướng dẫn chuyển khoản.";
            } else {
                $ghiChu = "[THANH TOÁN KHI NHẬN HÀNG (COD)] " . $ghiChu;
            }

            // Tạo đơn hàng
            $donHang = DonHang::create([
                'Ho_Ten_Nguoi_Nhan' => $request->Ho_Ten_Nguoi_Nhan,
                'So_Dien_Thoai_Nguoi_Nhan' => $request->So_Dien_Thoai_Nguoi_Nhan,
                'Email_Nguoi_Nhan' => $request->Email_Nguoi_Nhan,
                'Dia_Chi_Giao' => $request->Dia_Chi_Giao,
                'Ghi_Chu' => $ghiChu, // Đã xử lý ở trên
                'Tong_Tien' => $tongTien,
                'Phi_Van_Chuyen' => $phiVanChuyen,
                'Tien_Thanh_Toan' => $tienThanhToan,
                'Phuong_Thuc_Thanh_Toan' => $request->Phuong_Thuc_Thanh_Toan, // Đảm bảo dòng này có
                'Trang_Thai' => 'Cho_Xac_Nhan',
                
                // --- THÊM DÒNG NÀY ---
                'Ngay_Dat' => now(), 
                // ---------------------
            ]);

            // Tạo chi tiết đơn hàng và trừ tồn kho
            foreach ($cart as $item) {
                $bienThe = BienTheSanPham::findOrFail($item['Ma_Bien_The']);
                $sanPham = $bienThe->sanPham;

                ChiTietDonHang::create([
                    'Ma_Don_Hang' => $donHang->Ma_Don_Hang,
                    'Ma_Bien_The' => $item['Ma_Bien_The'],
                    'So_Luong' => $item['So_Luong'],
                    'Gia_Goc' => $sanPham->Gia_Goc,
                    'Gia_Ban' => $item['Gia_Ban'],
                    'Thanh_Tien' => $item['Gia_Ban'] * $item['So_Luong'],
                    'Ten_In_Ao' => $item['Ten_In_Ao'] ?? null,
                    'So_In_Ao' => $item['So_In_Ao'] ?? null
                ]);

                // Trừ tồn kho
                $bienThe->decrement('So_Luong_Ton', $item['So_Luong']);
                
                // Cập nhật trạng thái nếu hết hàng
                if ($bienThe->So_Luong_Ton <= 0) {
                    $bienThe->update(['Trang_Thai' => 'Het_Hang']);
                }
            }

            DB::commit();

            // Xóa giỏ hàng
            session()->forget('cart');

            return redirect()->route('checkout.success', $donHang->Ma_Don_Hang);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', $e->getMessage());
        }
    }

    // Trang đặt hàng thành công
    public function success($maDonHang)
    {
        $donHang = DonHang::with(['chiTietDonHangs.bienTheSanPham.sanPham', 'chiTietDonHangs.bienTheSanPham.size'])
            ->findOrFail($maDonHang);

        return view('checkout.success', compact('donHang'));
    }
}