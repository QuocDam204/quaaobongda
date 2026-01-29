<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnhSanPham extends Model
{
    protected $table = 'anh_san_pham';
    protected $primaryKey = 'Ma_Anh';
    public $timestamps = false;

    protected $fillable = [
        'Ma_San_Pham',
        'Duong_Dan',
        'Anh_Chinh'
    ];

    protected $casts = [
        'Anh_Chinh' => 'boolean'
    ];

    // Quan hệ: Ảnh thuộc 1 sản phẩm
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'Ma_San_Pham', 'Ma_San_Pham');
    }
}