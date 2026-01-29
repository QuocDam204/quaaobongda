<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    protected $table = 'chi_tiet_don_hang';
    protected $primaryKey = 'Ma_Chi_Tiet';
    public $timestamps = false;

    protected $fillable = [
        'Ma_Don_Hang',
        'Ma_Bien_The',
        'So_Luong',
        'Gia_Goc',
        'Gia_Ban',
        'Thanh_Tien',
        'Ten_In_Ao',
        'So_In_Ao'
    ];

    protected $casts = [
        'So_Luong' => 'integer',
        'Gia_Goc' => 'decimal:2',
        'Gia_Ban' => 'decimal:2',
        'Thanh_Tien' => 'decimal:2',
        'So_In_Ao' => 'integer'
    ];

    // Quan hệ: Chi tiết thuộc 1 đơn hàng
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'Ma_Don_Hang', 'Ma_Don_Hang');
    }

    // Quan hệ: Chi tiết thuộc 1 biến thể sản phẩm
    public function bienTheSanPham()
    {
        return $this->belongsTo(BienTheSanPham::class, 'Ma_Bien_The', 'Ma_Bien_The');
    }
}