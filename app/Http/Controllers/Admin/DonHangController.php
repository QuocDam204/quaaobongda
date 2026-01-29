<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonHangController extends Controller
{
    public function index(Request $request)
    {
        $query = DonHang::query();

        // Lọc theo trạng thái
        if ($request->filled('trang_thai')) {
            $query->where('Trang_Thai', $request->trang_thai);
        }

        // Tìm kiếm theo mã đơn, tên, hoặc số điện thoại
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Ma_Don_Hang', 'like', "%$search%")
                  ->orWhere('So_Dien_Thoai_Nguoi_Nhan', 'like', "%$search%")
                  ->orWhere('Ho_Ten_Nguoi_Nhan', 'like', "%$search%");
            });
        }

        $donHangs = $query->orderBy('Ngay_Dat', 'desc')->paginate(15);
        
        return view('admin.donhang.index', compact('donHangs'));
    }

    public function show($id)
    {
        // --- ĐÃ SỬA: bienThe -> bienTheSanPham ---
        $donHang = DonHang::with([
            'chiTietDonHangs.bienTheSanPham.sanPham',
            'chiTietDonHangs.bienTheSanPham.size'
        ])->findOrFail($id);
        
        return view('admin.donhang.show', compact('donHang'));
    }

    public function updateStatus(Request $request, $id)
    {
        $donHang = DonHang::findOrFail($id);

        $request->validate([
            'Trang_Thai' => 'required|in:Cho_Xac_Nhan,Da_Xac_Nhan,Dang_Giao,Hoan_Thanh,Huy'
        ]);

        // Kiểm tra logic trạng thái
        $currentStatus = $donHang->Trang_Thai;
        $newStatus = $request->Trang_Thai;

        // Không cho phép thay đổi trạng thái đơn hàng đã hoàn thành hoặc đã hủy
        if (in_array($currentStatus, ['Hoan_Thanh', 'Huy'])) {
            return back()->with('error', 'Không thể thay đổi trạng thái đơn hàng đã hoàn thành hoặc đã hủy!');
        }

        $donHang->update(['Trang_Thai' => $newStatus]);

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    public function destroy($id)
    {
        $donHang = DonHang::findOrFail($id);
        
        // Chỉ cho phép xóa đơn hàng bị hủy
        if ($donHang->Trang_Thai !== 'Huy') {
            return back()->with('error', 'Chỉ có thể xóa đơn hàng đã bị hủy!');
        }

        $donHang->delete();

        return redirect()->route('admin.donhang.index')
            ->with('success', 'Xóa đơn hàng thành công!');
    }

    public function print($id)
    {
        // --- ĐÃ SỬA: bienThe -> bienTheSanPham ---
        $donHang = DonHang::with([
            'chiTietDonHangs.bienTheSanPham.sanPham',
            'chiTietDonHangs.bienTheSanPham.size'
        ])->findOrFail($id);
        
        return view('admin.donhang.print', compact('donHang'));
    }

public function statistics(Request $request)
    {
        // 1. Lấy tham số lọc ngày tháng
        $tuNgay = $request->input('tu_ngay', date('Y-m-01'));
        $denNgay = $request->input('den_ngay', date('Y-m-d'));
        $trangThai = $request->input('trang_thai');

        // Định dạng thời gian đầy đủ để query chính xác
        $start = $tuNgay . ' 00:00:00';
        $end = $denNgay . ' 23:59:59';

        // 2. Query cơ bản cho các thống kê đơn giản
        $query = DonHang::whereBetween('Ngay_Dat', [$start, $end]);
        
        if ($trangThai) {
            $query->where('Trang_Thai', $trangThai);
        }

        // --- CÁC CHỈ SỐ CƠ BẢN ---
        $tongDonHang = $query->count();

        // Doanh thu (Chỉ tính đơn Hoàn thành để chính xác tiền thực thu)
        // Hoặc nếu muốn tính doanh thu dự kiến của cả đơn đang giao thì bỏ điều kiện Hoan_Thanh
        $doanhThu = DonHang::whereBetween('Ngay_Dat', [$start, $end])
            ->where('Trang_Thai', '!=', 'Huy') // Tính tất cả đơn trừ đơn hủy
            ->when($trangThai, function($q) use ($trangThai) {
                return $q->where('Trang_Thai', $trangThai);
            })
            ->sum('Tien_Thanh_Toan');

        $choXacNhan = DonHang::whereBetween('Ngay_Dat', [$start, $end])
            ->where('Trang_Thai', 'Cho_Xac_Nhan')
            ->count();

        $donHuy = DonHang::whereBetween('Ngay_Dat', [$start, $end])
            ->where('Trang_Thai', 'Huy')
            ->count();

        // --- PHẦN BỔ SUNG: TÍNH LỢI NHUẬN ---
        // Logic: Lấy (Số lượng * Giá nhập) của từng chi tiết đơn hàng
        $tongVon = DB::table('chi_tiet_don_hang')
            ->join('don_hang', 'chi_tiet_don_hang.Ma_Don_Hang', '=', 'don_hang.Ma_Don_Hang')
            ->join('bien_the_san_pham', 'chi_tiet_don_hang.Ma_Bien_The', '=', 'bien_the_san_pham.Ma_Bien_The')
            ->join('san_pham', 'bien_the_san_pham.Ma_San_Pham', '=', 'san_pham.Ma_San_Pham')
            ->whereBetween('don_hang.Ngay_Dat', [$start, $end])
            ->where('don_hang.Trang_Thai', '!=', 'Huy'); // Không tính vốn của đơn đã hủy

        if ($trangThai) {
            $tongVon->where('don_hang.Trang_Thai', $trangThai);
        }

        // Tính tổng vốn
        $tongVon = $tongVon->sum(DB::raw('chi_tiet_don_hang.So_Luong * san_pham.Gia_Nhap'));

        // Đếm số đơn hàng (để tính chi phí ship)
        $soDonHang = DonHang::whereBetween('Ngay_Dat', [$start, $end])
            ->where('Trang_Thai', '!=', 'Huy')
            ->when($trangThai, function($q) use ($trangThai) {
                return $q->where('Trang_Thai', $trangThai);
            })
            ->count();

        // Chi phí ship: 30,000 VNĐ x số đơn hàng
        $chiPhiShip = $soDonHang * 30000;

        // Lợi nhuận = Doanh thu - Tổng vốn - Chi phí ship
        $loiNhuan = $doanhThu - $tongVon - $chiPhiShip;
        // -------------------------------------

        // Thống kê số lượng đơn theo trạng thái
        $thongKeTheoTrangThai = DonHang::select('Trang_Thai', DB::raw('COUNT(*) as so_luong'))
            ->whereBetween('Ngay_Dat', [$start, $end])
            ->groupBy('Trang_Thai')
            ->get();

        // Thống kê doanh thu theo trạng thái
        $doanhThuTheoTrangThai = DonHang::select('Trang_Thai', DB::raw('SUM(Tien_Thanh_Toan) as doanh_thu'))
            ->whereBetween('Ngay_Dat', [$start, $end])
            ->groupBy('Trang_Thai')
            ->get();

        // Top sản phẩm bán chạy
        $topSanPham = DB::table('chi_tiet_don_hang')
            ->join('don_hang', 'chi_tiet_don_hang.Ma_Don_Hang', '=', 'don_hang.Ma_Don_Hang')
            ->join('bien_the_san_pham', 'chi_tiet_don_hang.Ma_Bien_The', '=', 'bien_the_san_pham.Ma_Bien_The')
            ->join('san_pham', 'bien_the_san_pham.Ma_San_Pham', '=', 'san_pham.Ma_San_Pham')
            ->join('size', 'bien_the_san_pham.Ma_Size', '=', 'size.Ma_Size')
            ->whereBetween('don_hang.Ngay_Dat', [$start, $end])
            ->where('don_hang.Trang_Thai', '!=', 'Huy')
            ->select(
                'san_pham.Ten_San_Pham as ten_san_pham',
                'size.Ten_Size as size',
                'bien_the_san_pham.Mau_Sac as mau_sac',
                DB::raw('SUM(chi_tiet_don_hang.So_Luong) as so_luong_ban'),
                DB::raw('SUM(chi_tiet_don_hang.Thanh_Tien) as doanh_thu')
            )
            ->groupBy('bien_the_san_pham.Ma_Bien_The', 'san_pham.Ten_San_Pham', 'size.Ten_Size', 'bien_the_san_pham.Mau_Sac')
            ->orderBy('so_luong_ban', 'desc')
            ->limit(10)
            ->get();

        return view('admin.donhang.statistics', compact(
            'tongDonHang',
            'doanhThu',
            'choXacNhan',
            'donHuy',
            'loiNhuan', // <--- Đã thêm biến này vào view
            'thongKeTheoTrangThai',
            'doanhThuTheoTrangThai',
            'topSanPham'
        ));
    }

    public function exportExcel(Request $request)
    {
        // Lấy tham số lọc
        $tuNgay = $request->input('tu_ngay', date('Y-m-01'));
        $denNgay = $request->input('den_ngay', date('Y-m-d'));
        $trangThai = $request->input('trang_thai');

        // Query đơn hàng
        // --- ĐÃ SỬA: bienThe -> bienTheSanPham ---
        $query = DonHang::with([
            'chiTietDonHangs.bienTheSanPham.sanPham',
            'chiTietDonHangs.bienTheSanPham.size'
        ])
        ->whereBetween('Ngay_Dat', [$tuNgay . ' 00:00:00', $denNgay . ' 23:59:59']);
        
        if ($trangThai) {
            $query->where('Trang_Thai', $trangThai);
        }

        $donHangs = $query->orderBy('Ngay_Dat', 'desc')->get();

        // Tạo file CSV
        $filename = "donhang_" . date('YmdHis') . ".csv";
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        // Thêm BOM để Excel hiển thị đúng tiếng Việt
        echo "\xEF\xBB\xBF";
        
        $output = fopen('php://output', 'w');
        
        // Header
        fputcsv($output, [
            'Mã ĐH',
            'Ngày đặt',
            'Khách hàng',
            'Số điện thoại',
            'Email',
            'Địa chỉ',
            'Tổng tiền',
            'Phí VC',
            'Thanh toán',
            'Trạng thái',
            'Ghi chú'
        ]);
        
        // Data
        foreach ($donHangs as $dh) {
            $trangThaiText = [
                'Cho_Xac_Nhan' => 'Chờ xác nhận',
                'Da_Xac_Nhan' => 'Đã xác nhận',
                'Dang_Giao' => 'Đang giao',
                'Hoan_Thanh' => 'Hoàn thành',
                'Huy' => 'Đã hủy'
            ][$dh->Trang_Thai] ?? $dh->Trang_Thai;
            
            // Format ngày
            // Kiểm tra xem Ngay_Dat có phải là object Carbon/DateTime không
            $ngayDat = $dh->Ngay_Dat instanceof \DateTime 
                        ? $dh->Ngay_Dat->format('d/m/Y H:i') 
                        : date('d/m/Y H:i', strtotime($dh->Ngay_Dat));

            fputcsv($output, [
                $dh->Ma_Don_Hang,
                $ngayDat,
                $dh->Ho_Ten_Nguoi_Nhan,
                $dh->So_Dien_Thoai_Nguoi_Nhan,
                $dh->Email_Nguoi_Nhan,
                $dh->Dia_Chi_Giao,
                $dh->Tong_Tien,
                $dh->Phi_Van_Chuyen,
                $dh->Tien_Thanh_Toan,
                $trangThaiText,
                $dh->Ghi_Chu
            ]);
        }
        
        fclose($output);
        exit();
    }
}