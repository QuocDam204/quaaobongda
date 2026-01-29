<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThuongHieu;
use Illuminate\Http\Request;

class ThuongHieuController extends Controller
{
    // Hiển thị danh sách thương hiệu
    public function index()
    {
        $thuongHieus = ThuongHieu::withCount('sanPhams')->paginate(10);
        return view('admin.thuonghieu.index', compact('thuongHieus'));
    }

    // Hiển thị form thêm mới
    public function create()
    {
        return view('admin.thuonghieu.create');
    }

    // Lưu thương hiệu mới
    public function store(Request $request)
    {
        $request->validate([
            'Ten_Thuong_Hieu' => 'required|string|max:100|unique:thuong_hieu,Ten_Thuong_Hieu'
        ], [
            'Ten_Thuong_Hieu.required' => 'Vui lòng nhập tên thương hiệu',
            'Ten_Thuong_Hieu.max' => 'Tên thương hiệu không được quá 100 ký tự',
            'Ten_Thuong_Hieu.unique' => 'Tên thương hiệu đã tồn tại'
        ]);

        ThuongHieu::create([
            'Ten_Thuong_Hieu' => $request->Ten_Thuong_Hieu
        ]);

        return redirect()->route('admin.thuonghieu.index')
            ->with('success', 'Thêm thương hiệu thành công!');
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        $thuongHieu = ThuongHieu::findOrFail($id);
        return view('admin.thuonghieu.edit', compact('thuongHieu'));
    }

    // Cập nhật thương hiệu
    public function update(Request $request, $id)
    {
        $thuongHieu = ThuongHieu::findOrFail($id);

        $request->validate([
            'Ten_Thuong_Hieu' => 'required|string|max:100|unique:thuong_hieu,Ten_Thuong_Hieu,' . $id . ',Ma_Thuong_Hieu'
        ], [
            'Ten_Thuong_Hieu.required' => 'Vui lòng nhập tên thương hiệu',
            'Ten_Thuong_Hieu.max' => 'Tên thương hiệu không được quá 100 ký tự',
            'Ten_Thuong_Hieu.unique' => 'Tên thương hiệu đã tồn tại'
        ]);

        $thuongHieu->update([
            'Ten_Thuong_Hieu' => $request->Ten_Thuong_Hieu
        ]);

        return redirect()->route('admin.thuonghieu.index')
            ->with('success', 'Cập nhật thương hiệu thành công!');
    }

    // Xóa thương hiệu
    public function destroy($id)
    {
        $thuongHieu = ThuongHieu::findOrFail($id);
        
        // Kiểm tra xem thương hiệu có sản phẩm không
        if ($thuongHieu->sanPhams()->count() > 0) {
            return redirect()->route('admin.thuonghieu.index')
                ->with('error', 'Không thể xóa thương hiệu đã có sản phẩm!');
        }

        $thuongHieu->delete();

        return redirect()->route('admin.thuonghieu.index')
            ->with('success', 'Xóa thương hiệu thành công!');
    }
}