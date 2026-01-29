<?php

namespace App\Http\Controllers;

use App\Models\BienTheSanPham;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Thêm vào giỏ hàng
    public function add(Request $request)
    {
        $request->validate([
            'Ma_Bien_The' => 'required|exists:bien_the_san_pham,Ma_Bien_The',
            'So_Luong' => 'required|integer|min:1',
            'Ten_In_Ao' => 'nullable|string|max:50',
            'So_In_Ao' => 'nullable|integer|min:0|max:99'
        ]);

        $bienThe = BienTheSanPham::with(['sanPham.anhSanPhams', 'size'])
            ->findOrFail($request->Ma_Bien_The);

        // Kiểm tra tồn kho
        if ($bienThe->So_Luong_Ton < $request->So_Luong) {
            return back()->with('error', 'Sản phẩm không đủ số lượng trong kho!');
        }

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        // Tạo key duy nhất cho sản phẩm (bao gồm cả tên và số in áo nếu có)
        $cartKey = $request->Ma_Bien_The;
        if ($request->Ten_In_Ao || $request->So_In_Ao) {
            $cartKey .= '_' . ($request->Ten_In_Ao ?? '') . '_' . ($request->So_In_Ao ?? '');
        }

        // Nếu sản phẩm đã có trong giỏ, tăng số lượng
        if (isset($cart[$cartKey])) {
            $soLuongMoi = $cart[$cartKey]['So_Luong'] + $request->So_Luong;
            
            // Kiểm tra lại tồn kho
            if ($bienThe->So_Luong_Ton < $soLuongMoi) {
                return back()->with('error', 'Vượt quá số lượng tồn kho!');
            }
            
            $cart[$cartKey]['So_Luong'] = $soLuongMoi;
        } else {
            // Thêm sản phẩm mới vào giỏ
            $anhChinh = $bienThe->sanPham->anhSanPhams->where('Anh_Chinh', true)->first()
                     ?? $bienThe->sanPham->anhSanPhams->first();

            $cart[$cartKey] = [
                'Ma_Bien_The' => $bienThe->Ma_Bien_The,
                'Ten_San_Pham' => $bienThe->sanPham->Ten_San_Pham,
                'Size' => $bienThe->size->Ten_Size,
                'Mau_Sac' => $bienThe->Mau_Sac,
                'Gia_Ban' => $bienThe->Gia_Ban,
                'So_Luong' => $request->So_Luong,
                'Anh' => $anhChinh ? $anhChinh->Duong_Dan : null,
                'Ten_In_Ao' => $request->Ten_In_Ao,
                'So_In_Ao' => $request->So_In_Ao
            ];
        }

        // Lưu giỏ hàng vào session
        session()->put('cart', $cart);

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    // Cập nhật số lượng
    public function update(Request $request, $cartKey)
    {
        $request->validate([
            'So_Luong' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$cartKey])) {
            return back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
        }

        // Kiểm tra tồn kho
        $bienThe = BienTheSanPham::findOrFail($cart[$cartKey]['Ma_Bien_The']);
        if ($bienThe->So_Luong_Ton < $request->So_Luong) {
            return back()->with('error', 'Số lượng vượt quá tồn kho!');
        }

        $cart[$cartKey]['So_Luong'] = $request->So_Luong;
        session()->put('cart', $cart);

        return back()->with('success', 'Đã cập nhật số lượng!');
    }

    // Xóa sản phẩm khỏi giỏ
    public function remove($cartKey)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    // Xóa toàn bộ giỏ hàng
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }

    // Đếm số lượng sản phẩm trong giỏ (dùng cho header)
    public static function count()
    {
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'So_Luong'));
    }
}