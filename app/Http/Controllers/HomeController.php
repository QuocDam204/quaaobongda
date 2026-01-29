<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\DanhMuc;
use App\Models\ThuongHieu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Trang chủ
    public function index()
    {
        // Sản phẩm nổi bật (mới nhất)
        $sanPhamMoi = SanPham::with(['danhMuc', 'thuongHieu', 'anhSanPhams'])
            ->where('Trang_Thai', 'Dang_Ban')
            ->orderBy('Ngay_Tao', 'desc')
            ->limit(8)
            ->get();

        // Sản phẩm giảm giá
        $sanPhamGiamGia = SanPham::with(['danhMuc', 'thuongHieu', 'anhSanPhams'])
            ->where('Trang_Thai', 'Dang_Ban')
            ->whereNotNull('Gia_Khuyen_Mai')
            ->orderBy('Ngay_Tao', 'desc')
            ->limit(8)
            ->get();

        $danhMucs = DanhMuc::withCount('sanPhams')->get();

        return view('home', compact('sanPhamMoi', 'sanPhamGiamGia', 'danhMucs'));
    }

    // Danh sách sản phẩm
    public function products(Request $request)
    {
        $query = SanPham::with(['danhMuc', 'thuongHieu', 'anhSanPhams'])
            ->where('Trang_Thai', 'Dang_Ban');

        // Lọc theo danh mục
        if ($request->has('danh_muc') && $request->danh_muc != '') {
            $query->where('Ma_Danh_Muc', $request->danh_muc);
        }

        // Lọc theo thương hiệu
        if ($request->has('thuong_hieu') && $request->thuong_hieu != '') {
            $query->where('Ma_Thuong_Hieu', $request->thuong_hieu);
        }

        // Tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('Ten_San_Pham', 'like', "%{$search}%");
        }

        // Sắp xếp
        $sort = $request->get('sort', 'moi_nhat');
        switch ($sort) {
            case 'gia_thap':
                $query->orderByRaw('COALESCE(Gia_Khuyen_Mai, Gia_Goc) ASC');
                break;
            case 'gia_cao':
                $query->orderByRaw('COALESCE(Gia_Khuyen_Mai, Gia_Goc) DESC');
                break;
            case 'ten_az':
                $query->orderBy('Ten_San_Pham', 'ASC');
                break;
            default:
                $query->orderBy('Ngay_Tao', 'DESC');
        }

        $sanPhams = $query->paginate(12)->withQueryString();

        $danhMucs = DanhMuc::all();
        $thuongHieus = ThuongHieu::all();

        return view('products.index', compact('sanPhams', 'danhMucs', 'thuongHieus'));
    }

    // Chi tiết sản phẩm
    public function productDetail($id)
    {
        $sanPham = SanPham::with([
            'danhMuc', 
            'thuongHieu', 
            'anhSanPhams',
            'bienTheSanPhams.size'
        ])
        ->where('Trang_Thai', 'Dang_Ban')
        ->findOrFail($id);

        // Sản phẩm liên quan (cùng danh mục)
        $sanPhamLienQuan = SanPham::with(['danhMuc', 'thuongHieu', 'anhSanPhams'])
            ->where('Trang_Thai', 'Dang_Ban')
            ->where('Ma_Danh_Muc', $sanPham->Ma_Danh_Muc)
            ->where('Ma_San_Pham', '!=', $id)
            ->limit(4)
            ->get();

        return view('products.detail', compact('sanPham', 'sanPhamLienQuan'));
    }

    // Trang giới thiệu
    public function about()
    {
        return view('about');
    }

    // Trang liên hệ
    public function contact()
    {
        return view('contact');
    }
}