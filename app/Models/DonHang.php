<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'don_hang';
    protected $primaryKey = 'Ma_Don_Hang';
    public $timestamps = false;

    protected $fillable = [
        'Ngay_Dat',
        'Ho_Ten_Nguoi_Nhan',
        'So_Dien_Thoai_Nguoi_Nhan',
        'Email_Nguoi_Nhan',
        'Dia_Chi_Giao',
        'Ghi_Chu',
        'Tong_Tien',
        'Phi_Van_Chuyen',
        'Tien_Thanh_Toan',
        'Phuong_Thuc_Thanh_Toan',  // ← THÊM DÒNG NÀY
        'Trang_Thai'
    ];

    protected $casts = [
        'Ngay_Dat' => 'datetime',
        'Tong_Tien' => 'decimal:2',
        'Phi_Van_Chuyen' => 'decimal:2',
        'Tien_Thanh_Toan' => 'decimal:2'
    ];

    public function chiTietDonHangs()
    {
        return $this->hasMany(ChiTietDonHang::class, 'Ma_Don_Hang', 'Ma_Don_Hang');
    }
}