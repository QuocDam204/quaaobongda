<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use Illuminate\Http\Request;

class DanhMucController extends Controller
{
    // Hiển thị danh sách danh mục
    public function index()
    {
        $danhMucs = DanhMuc::withCount('sanPhams')->paginate(10);
        return view('admin.danhmuc.index', compact('danhMucs'));
    }

    // Hiển thị form thêm mới
    public function create()
    {
        return view('admin.danhmuc.create');
    }

    // Lưu danh mục mới
    public function store(Request $request)
    {
        $request->validate([
            'Ten_Danh_Muc' => 'required|string|max:100|unique:danh_muc,Ten_Danh_Muc'
        ], [
            'Ten_Danh_Muc.required' => 'Vui lòng nhập tên danh mục',
            'Ten_Danh_Muc.max' => 'Tên danh mục không được quá 100 ký tự',
            'Ten_Danh_Muc.unique' => 'Tên danh mục đã tồn tại'
        ]);

        DanhMuc::create([
            'Ten_Danh_Muc' => $request->Ten_Danh_Muc
        ]);

        return redirect()->route('admin.danhmuc.index')
            ->with('success', 'Thêm danh mục thành công!');
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        $danhMuc = DanhMuc::findOrFail($id);
        return view('admin.danhmuc.edit', compact('danhMuc'));
    }

    // Cập nhật danh mục
    public function update(Request $request, $id)
    {
        $danhMuc = DanhMuc::findOrFail($id);

        $request->validate([
            'Ten_Danh_Muc' => 'required|string|max:100|unique:danh_muc,Ten_Danh_Muc,' . $id . ',Ma_Danh_Muc'
        ], [
            'Ten_Danh_Muc.required' => 'Vui lòng nhập tên danh mục',
            'Ten_Danh_Muc.max' => 'Tên danh mục không được quá 100 ký tự',
            'Ten_Danh_Muc.unique' => 'Tên danh mục đã tồn tại'
        ]);

        $danhMuc->update([
            'Ten_Danh_Muc' => $request->Ten_Danh_Muc
        ]);

        return redirect()->route('admin.danhmuc.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    // Xóa danh mục
    public function destroy($id)
    {
        $danhMuc = DanhMuc::findOrFail($id);
        
        // Kiểm tra xem danh mục có sản phẩm không
        if ($danhMuc->sanPhams()->count() > 0) {
            return redirect()->route('admin.danhmuc.index')
                ->with('error', 'Không thể xóa danh mục đã có sản phẩm!');
        }

        $danhMuc->delete();

        return redirect()->route('admin.danhmuc.index')
            ->with('success', 'Xóa danh mục thành công!');
    }
}