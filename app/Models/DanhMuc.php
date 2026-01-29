<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    protected $table = 'danh_muc';
    protected $primaryKey = 'Ma_Danh_Muc';
    public $timestamps = false;

    protected $fillable = [
        'Ten_Danh_Muc'
    ];

    // Quan hệ: 1 danh mục có nhiều sản phẩm
    public function sanPhams()
    {
        return $this->hasMany(SanPham::class, 'Ma_Danh_Muc', 'Ma_Danh_Muc');
    }
}