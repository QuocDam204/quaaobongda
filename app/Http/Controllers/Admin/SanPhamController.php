<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\DanhMuc;
use App\Models\ThuongHieu;
use App\Models\AnhSanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SanPhamController extends Controller
{
    // 1. Hiển thị danh sách
    public function index(Request $request)
    {
        $query = SanPham::with(['danhMuc', 'thuongHieu', 'anhSanPhams']);

        if ($request->has('search')) {
            $query->where('Ten_San_Pham', 'like', "%{$request->search}%");
        }
        if ($request->has('danh_muc') && $request->danh_muc != '') {
            $query->where('Ma_Danh_Muc', $request->danh_muc);
        }
        if ($request->has('trang_thai') && $request->trang_thai != '') {
            $query->where('Trang_Thai', $request->trang_thai);
        }

        $sanPhams = $query->orderBy('Ngay_Tao', 'desc')->paginate(12);
        $danhMucs = DanhMuc::all();

        return view('admin.sanpham.index', compact('sanPhams', 'danhMucs'));
    }

    // 2. Form thêm mới
    public function create()
    {
        $danhMucs = DanhMuc::all();
        $thuongHieus = ThuongHieu::all();
        return view('admin.sanpham.create', compact('danhMucs', 'thuongHieus'));
    }

    // 3. Xử lý lưu (Store) - Đã thêm logic Giá Gốc > Giá Nhập
    public function store(Request $request)
    {
        $request->validate([
            'Ten_San_Pham' => 'required|string|max:200',
            'Ma_Danh_Muc' => 'required|exists:danh_muc,Ma_Danh_Muc',
            
            // Validate Giá Nhập
            'Gia_Nhap' => 'required|numeric|min:0',
            
            // Validate Giá Gốc: Phải là số, không âm, và LỚN HƠN Giá Nhập
            'Gia_Goc' => 'required|numeric|min:0|gt:Gia_Nhap', 
            
            'Trang_Thai' => 'required|in:Dang_Ban,Ngung_Ban',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ], [
            'Ten_San_Pham.required' => 'Vui lòng nhập tên sản phẩm',
            'Gia_Nhap.required' => 'Vui lòng nhập giá nhập',
            'Gia_Goc.required' => 'Vui lòng nhập giá gốc',
            
            // Thông báo lỗi tùy chỉnh cho logic giá
            'Gia_Goc.gt' => 'Giá gốc phải lớn hơn giá nhập để đảm bảo có lãi!',
            'Gia_Goc.min' => 'Giá gốc không được âm',
        ]);

        $sanPham = SanPham::create($request->all());

        if ($request->hasFile('images')) {
            $isFirst = true;
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                AnhSanPham::create([
                    'Ma_San_Pham' => $sanPham->Ma_San_Pham,
                    'Duong_Dan' => $path,
                    'Anh_Chinh' => $isFirst
                ]);
                $isFirst = false;
            }
        }

        return redirect()->route('admin.sanpham.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    // 4. Xem chi tiết
    public function show($id)
    {
        $sanPham = SanPham::findOrFail($id);
        return view('admin.sanpham.show', compact('sanPham'));
    }

    // 5. Form chỉnh sửa
    public function edit($id)
    {
        $sanPham = SanPham::with('anhSanPhams')->findOrFail($id);
        $danhMucs = DanhMuc::all();
        $thuongHieus = ThuongHieu::all();
        return view('admin.sanpham.edit', compact('sanPham', 'danhMucs', 'thuongHieus'));
    }

    // 6. Xử lý cập nhật (Update) - Đã thêm logic Giá Gốc > Giá Nhập
    public function update(Request $request, $id)
    {
        $sanPham = SanPham::findOrFail($id);

        $request->validate([
            'Ten_San_Pham' => 'required|string|max:200',
            'Ma_Danh_Muc' => 'required|exists:danh_muc,Ma_Danh_Muc',
            
            // Validate Giá Nhập
            'Gia_Nhap' => 'required|numeric|min:0',
            
            // Validate Giá Gốc: LỚN HƠN Giá Nhập
            'Gia_Goc' => 'required|numeric|min:0|gt:Gia_Nhap',
            
            'Trang_Thai' => 'required|in:Dang_Ban,Ngung_Ban',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ], [
            'Gia_Goc.gt' => 'Giá gốc phải lớn hơn giá nhập (Không được bán lỗ)!',
        ]);

        // Cập nhật dữ liệu (loại bỏ images khỏi mảng data vì xử lý riêng)
        $sanPham->update($request->except(['images']));

        // Xử lý upload ảnh mới thêm vào
        if ($request->hasFile('images')) {
            // Kiểm tra xem sản phẩm đã có ảnh chính chưa
            $hasMainImage = $sanPham->anhSanPhams()->where('Anh_Chinh', true)->exists();
            
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                AnhSanPham::create([
                    'Ma_San_Pham' => $sanPham->Ma_San_Pham,
                    'Duong_Dan' => $path,
                    // Nếu chưa có ảnh chính nào thì ảnh mới này là chính
                    'Anh_Chinh' => !$hasMainImage 
                ]);
                $hasMainImage = true; // Đánh dấu đã có ảnh chính
            }
        }

        return redirect()->route('admin.sanpham.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    // 7. Xóa ảnh
    public function deleteImage($sanPhamId, $imageId)
    {
        $anh = AnhSanPham::findOrFail($imageId);
        
        // Kiểm tra ảnh có thuộc đúng sản phẩm không
        if ($anh->Ma_San_Pham != $sanPhamId) {
            abort(404);
        }

        // Không cho xóa nếu chỉ còn 1 ảnh
        if ($anh->sanPham->anhSanPhams()->count() <= 1) {
            return back()->with('error', 'Không thể xóa ảnh cuối cùng!');
        }

        $wasMain = $anh->Anh_Chinh;
        Storage::disk('public')->delete($anh->Duong_Dan);
        $anh->delete();

        // Nếu xóa ảnh chính, chọn ảnh khác làm ảnh chính
        if ($wasMain) {
            $newMain = AnhSanPham::where('Ma_San_Pham', $sanPhamId)->first();
            if ($newMain) $newMain->update(['Anh_Chinh' => true]);
        }

        return back()->with('success', 'Đã xóa ảnh!');
    }

    // 8. Đặt làm ảnh chính
    public function setMainImage($sanPhamId, $imageId)
    {
        $anh = AnhSanPham::findOrFail($imageId);
        
        if ($anh->Ma_San_Pham != $sanPhamId) {
            abort(404);
        }

        // Reset tất cả ảnh của sản phẩm này về false
        AnhSanPham::where('Ma_San_Pham', $sanPhamId)->update(['Anh_Chinh' => false]);
        
        // Set ảnh được chọn thành true
        $anh->update(['Anh_Chinh' => true]);

        return back()->with('success', 'Đã đặt làm ảnh chính!');
    }

    // 9. Xóa sản phẩm
    public function destroy($id)
    {
        $sanPham = SanPham::findOrFail($id);
        
        // Xóa tất cả ảnh trong storage trước
        foreach($sanPham->anhSanPhams as $anh) {
            Storage::disk('public')->delete($anh->Duong_Dan);
        }
        
        $sanPham->delete(); // Các bảng con sẽ tự xóa nếu có thiết lập cascade ở database
        
        return redirect()->route('admin.sanpham.index')->with('success', 'Xóa thành công');
    }
}