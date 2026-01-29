<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'san_pham';
    // QUAN TRỌNG: Khai báo khóa chính không phải là 'id'
    protected $primaryKey = 'Ma_San_Pham';
    
    // Nếu khóa chính tự tăng (Auto Increment) thì để true, nếu không thì false
    public $incrementing = true; 

    // Tắt timestamps nếu bảng của bạn không có created_at, updated_at
    // Nếu có thì xóa dòng này hoặc để true
    public $timestamps = false; 

    protected $fillable = [
        'Ma_Danh_Muc',
        'Ma_Thuong_Hieu',
        'Ten_San_Pham',
        'Mo_Ta_Ngan',
        'Mo_Ta',
        'Gia_Nhap',
        'Gia_Goc',
        'Gia_Khuyen_Mai',
        'Trang_Thai',
        'Ngay_Tao' // Nếu bạn tự quản lý ngày tạo
    ];

    protected $casts = [  
        'Gia_Nhap' => 'decimal:2',
        'Gia_Goc' => 'decimal:2',
        'Gia_Khuyen_Mai' => 'decimal:2',
        'Ngay_Tao' => 'datetime'
    ];

    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'Ma_Danh_Muc', 'Ma_Danh_Muc');
    }

    public function thuongHieu()
    {
        return $this->belongsTo(ThuongHieu::class, 'Ma_Thuong_Hieu', 'Ma_Thuong_Hieu');
    }

    public function anhSanPhams()
    {
        return $this->hasMany(AnhSanPham::class, 'Ma_San_Pham', 'Ma_San_Pham');
    }

    public function bienTheSanPhams()
    {
        return $this->hasMany(BienTheSanPham::class, 'Ma_San_Pham', 'Ma_San_Pham');
    }
}