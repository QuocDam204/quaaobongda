<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BienTheSanPham extends Model
{
    protected $table = 'bien_the_san_pham';
    protected $primaryKey = 'Ma_Bien_The';
    public $timestamps = false;

    protected $fillable = [
        'Ma_San_Pham',
        'Ma_Size',
        'Mau_Sac',
        'SKU',
        'Gia_Ban',
        'So_Luong_Ton',
        'Trang_Thai'
    ];

    protected $casts = [
        'Gia_Ban' => 'decimal:2',
        'So_Luong_Ton' => 'integer'
    ];

    // Quan hệ: Biến thể thuộc 1 sản phẩm
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'Ma_San_Pham', 'Ma_San_Pham');
    }

    // Quan hệ: Biến thể có 1 size
    public function size()
    {
        return $this->belongsTo(Size::class, 'Ma_Size', 'Ma_Size');
    }

    // Quan hệ: Biến thể có nhiều chi tiết đơn hàng
    public function chiTietDonHangs()
    {
        return $this->hasMany(ChiTietDonHang::class, 'Ma_Bien_The', 'Ma_Bien_The');
    }
}