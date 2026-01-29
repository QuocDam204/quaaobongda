<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'size';
    protected $primaryKey = 'Ma_Size';
    public $timestamps = false;

    protected $fillable = [
        'Ten_Size',
        'Nhom_Size'
    ];

    // Quan hệ: 1 size có nhiều biến thể sản phẩm
    public function bienTheSanPhams()
    {
        return $this->hasMany(BienTheSanPham::class, 'Ma_Size', 'Ma_Size');
    }
}