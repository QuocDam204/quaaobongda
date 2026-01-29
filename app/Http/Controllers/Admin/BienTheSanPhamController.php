<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BienTheSanPham;
use App\Models\SanPham;
use App\Models\Size;
use Illuminate\Http\Request;

class BienTheSanPhamController extends Controller
{
    // Hiển thị danh sách biến thể của sản phẩm
    public function index($sanPhamId)
    {
        $sanPham = SanPham::with(['bienTheSanPhams.size'])->findOrFail($sanPhamId);
        return view('admin.bienthe.index', compact('sanPham'));
    }

    // Hiển thị form thêm biến thể
    public function create($sanPhamId)
    {
        $sanPham = SanPham::findOrFail($sanPhamId);
        $sizes = Size::all();
        return view('admin.bienthe.create', compact('sanPham', 'sizes'));
    }

    // Lưu biến thể mới
    public function store(Request $request, $sanPhamId)
    {
        $sanPham = SanPham::findOrFail($sanPhamId);

        $request->validate([
            'Ma_Size' => 'required|exists:size,Ma_Size',
            'Mau_Sac' => 'required|string|max:50',
            'SKU' => 'nullable|string|max:50|unique:bien_the_san_pham,SKU',
            'Gia_Ban' => 'required|numeric|min:0',
            'So_Luong_Ton' => 'required|integer|min:0',
            'Trang_Thai' => 'required|in:Con_Hang,Het_Hang'
        ], [
            'Ma_Size.required' => 'Vui lòng chọn size',
            'Mau_Sac.required' => 'Vui lòng nhập màu sắc',
            'Gia_Ban.required' => 'Vui lòng nhập giá bán',
            'So_Luong_Ton.required' => 'Vui lòng nhập số lượng tồn',
            'SKU.unique' => 'Mã SKU đã tồn tại'
        ]);

        // Kiểm tra trùng lặp size và màu
        $exists = BienTheSanPham::where('Ma_San_Pham', $sanPhamId)
            ->where('Ma_Size', $request->Ma_Size)
            ->where('Mau_Sac', $request->Mau_Sac)
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Biến thể với size và màu này đã tồn tại!');
        }

        BienTheSanPham::create([
            'Ma_San_Pham' => $sanPhamId,
            'Ma_Size' => $request->Ma_Size,
            'Mau_Sac' => $request->Mau_Sac,
            'SKU' => $request->SKU,
            'Gia_Ban' => $request->Gia_Ban,
            'So_Luong_Ton' => $request->So_Luong_Ton,
            'Trang_Thai' => $request->Trang_Thai
        ]);

        return redirect()->route('admin.bienthe.index', $sanPhamId)
            ->with('success', 'Thêm biến thể thành công!');
    }

    // Hiển thị form sửa biến thể
    public function edit($sanPhamId, $id)
    {
        $sanPham = SanPham::findOrFail($sanPhamId);
        $bienThe = BienTheSanPham::where('Ma_San_Pham', $sanPhamId)->findOrFail($id);
        $sizes = Size::all();
        return view('admin.bienthe.edit', compact('sanPham', 'bienThe', 'sizes'));
    }

    // Cập nhật biến thể
    public function update(Request $request, $sanPhamId, $id)
    {
        $bienThe = BienTheSanPham::where('Ma_San_Pham', $sanPhamId)->findOrFail($id);

        $request->validate([
            'Ma_Size' => 'required|exists:size,Ma_Size',
            'Mau_Sac' => 'required|string|max:50',
            'SKU' => 'nullable|string|max:50|unique:bien_the_san_pham,SKU,' . $id . ',Ma_Bien_The',
            'Gia_Ban' => 'required|numeric|min:0',
            'So_Luong_Ton' => 'required|integer|min:0',
            'Trang_Thai' => 'required|in:Con_Hang,Het_Hang'
        ], [
            'Ma_Size.required' => 'Vui lòng chọn size',
            'Mau_Sac.required' => 'Vui lòng nhập màu sắc',
            'Gia_Ban.required' => 'Vui lòng nhập giá bán',
            'So_Luong_Ton.required' => 'Vui lòng nhập số lượng tồn',
            'SKU.unique' => 'Mã SKU đã tồn tại'
        ]);

        // Kiểm tra trùng lặp size và màu (trừ chính nó)
        $exists = BienTheSanPham::where('Ma_San_Pham', $sanPhamId)
            ->where('Ma_Size', $request->Ma_Size)
            ->where('Mau_Sac', $request->Mau_Sac)
            ->where('Ma_Bien_The', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Biến thể với size và màu này đã tồn tại!');
        }

        $bienThe->update([
            'Ma_Size' => $request->Ma_Size,
            'Mau_Sac' => $request->Mau_Sac,
            'SKU' => $request->SKU,
            'Gia_Ban' => $request->Gia_Ban,
            'So_Luong_Ton' => $request->So_Luong_Ton,
            'Trang_Thai' => $request->Trang_Thai
        ]);

        return redirect()->route('admin.bienthe.index', $sanPhamId)
            ->with('success', 'Cập nhật biến thể thành công!');
    }

    // Xóa biến thể
    public function destroy($sanPhamId, $id)
    {
        $bienThe = BienTheSanPham::where('Ma_San_Pham', $sanPhamId)->findOrFail($id);
        
        // Kiểm tra biến thể có trong đơn hàng chưa
        if ($bienThe->chiTietDonHangs()->count() > 0) {
            return redirect()->route('admin.bienthe.index', $sanPhamId)
                ->with('error', 'Không thể xóa biến thể đã có trong đơn hàng!');
        }

        $bienThe->delete();

        return redirect()->route('admin.bienthe.index', $sanPhamId)
            ->with('success', 'Xóa biến thể thành công!');
    }

    // Cập nhật số lượng tồn (AJAX)
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'So_Luong_Ton' => 'required|integer|min:0'
        ]);

        $bienThe = BienTheSanPham::findOrFail($id);
        $bienThe->update([
            'So_Luong_Ton' => $request->So_Luong_Ton,
            'Trang_Thai' => $request->So_Luong_Ton > 0 ? 'Con_Hang' : 'Het_Hang'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật số lượng thành công!'
        ]);
    }
}