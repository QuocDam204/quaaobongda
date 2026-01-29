<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\DanhMuc;
use App\Models\ThuongHieu;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
        $query = SanPham::query();

        // Lọc theo từ khóa
        if ($request->filled('search')) {
            $query->where('Ten_San_Pham', 'like', '%' . $request->search . '%');
        }

        // Lọc theo danh mục
        if ($request->filled('danh_muc')) {
            $query->where('Ma_Danh_Muc', $request->danh_muc);
        }

        // Lọc theo thương hiệu
        if ($request->filled('thuong_hieu')) {
            $query->where('Ma_Thuong_Hieu', $request->thuong_hieu);
        }

        // Sắp xếp
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'gia_thap':
                    $query->orderBy('Gia_Khuyen_Mai', 'asc');
                    break;
                case 'gia_cao':
                    $query->orderBy('Gia_Khuyen_Mai', 'desc');
                    break;
                case 'ten_az':
                    $query->orderBy('Ten_San_Pham', 'asc');
                    break;
                default:
                    $query->orderBy('Ngay_Tao', 'desc'); // Mới nhất
            }
        } else {
            $query->orderBy('Ngay_Tao', 'desc');
        }

        $sanPhams = $query->with('anhSanPhams')->paginate(12);
        $danhMucs = DanhMuc::all();
        $thuongHieus = ThuongHieu::all();

        return view('products.index', compact('sanPhams', 'danhMucs', 'thuongHieus'));
    }

    // Hiển thị chi tiết sản phẩm
    public function show($id)
    {
        // QUAN TRỌNG: with('bienTheSanPhams.size') để JavaScript lấy được tên Size
        $sanPham = SanPham::with([
            'danhMuc', 
            'thuongHieu', 
            'anhSanPhams', 
            'bienTheSanPhams.size' 
        ])->findOrFail($id);

        // Sản phẩm liên quan
        $sanPhamLienQuan = SanPham::where('Ma_Danh_Muc', $sanPham->Ma_Danh_Muc)
            ->where('Ma_San_Pham', '!=', $id)
            ->with('anhSanPhams')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('products.show', compact('sanPham', 'sanPhamLienQuan'));
    }
}