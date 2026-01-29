<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    // Hiển thị danh sách size
    public function index()
    {
        $sizes = Size::orderBy('Nhom_Size')->orderBy('Ten_Size')->paginate(15);
        return view('admin.size.index', compact('sizes'));
    }

    // Hiển thị form thêm mới
    public function create()
    {
        return view('admin.size.create');
    }

    // Lưu size mới
    public function store(Request $request)
    {
        $request->validate([
            'Ten_Size' => 'required|string|max:20|unique:size,Ten_Size',
            'Nhom_Size' => 'nullable|string|max:255'
        ], [
            'Ten_Size.required' => 'Vui lòng nhập tên size',
            'Ten_Size.max' => 'Tên size không được quá 20 ký tự',
            'Ten_Size.unique' => 'Tên size đã tồn tại',
            'Nhom_Size.max' => 'Nhóm size không được quá 255 ký tự'
        ]);

        Size::create([
            'Ten_Size' => $request->Ten_Size,
            'Nhom_Size' => $request->Nhom_Size
        ]);

        return redirect()->route('admin.size.index')
            ->with('success', 'Thêm size thành công!');
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        $size = Size::findOrFail($id);
        return view('admin.size.edit', compact('size'));
    }

    // Cập nhật size
    public function update(Request $request, $id)
    {
        $size = Size::findOrFail($id);

        $request->validate([
            'Ten_Size' => 'required|string|max:20|unique:size,Ten_Size,' . $id . ',Ma_Size',
            'Nhom_Size' => 'nullable|string|max:255'
        ], [
            'Ten_Size.required' => 'Vui lòng nhập tên size',
            'Ten_Size.max' => 'Tên size không được quá 20 ký tự',
            'Ten_Size.unique' => 'Tên size đã tồn tại',
            'Nhom_Size.max' => 'Nhóm size không được quá 255 ký tự'
        ]);

        $size->update([
            'Ten_Size' => $request->Ten_Size,
            'Nhom_Size' => $request->Nhom_Size
        ]);

        return redirect()->route('admin.size.index')
            ->with('success', 'Cập nhật size thành công!');
    }

    // Xóa size
    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        
        // Kiểm tra xem size có biến thể sản phẩm không
        if ($size->bienTheSanPhams()->count() > 0) {
            return redirect()->route('admin.size.index')
                ->with('error', 'Không thể xóa size đã có sản phẩm!');
        }

        $size->delete();

        return redirect()->route('admin.size.index')
            ->with('success', 'Xóa size thành công!');
    }
}