<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThuongHieu extends Model
{
    protected $table = 'thuong_hieu';
    protected $primaryKey = 'Ma_Thuong_Hieu';
    public $timestamps = false;

    protected $fillable = [
        'Ten_Thuong_Hieu'
    ];

    // Quan hệ: 1 thương hiệu có nhiều sản phẩm
    public function sanPhams()
    {
        return $this->hasMany(SanPham::class, 'Ma_Thuong_Hieu', 'Ma_Thuong_Hieu');
    }
}