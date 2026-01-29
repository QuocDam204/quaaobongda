<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class QuanTriVien extends Authenticatable
{
    use Notifiable;

    protected $table = 'quan_tri_vien';
    protected $primaryKey = 'Ma_Admin';
    public $timestamps = false;

    protected $fillable = [
        'Ho_Ten',
        'Tai_Khoan',
        'Mat_Khau',
        'Email',
        'So_Dien_Thoai',
        'Ngay_Tao'
    ];

    protected $hidden = [
        'Mat_Khau',
        'remember_token'
    ];

    protected $casts = [
        'Ngay_Tao' => 'datetime'
    ];

    // Laravel Auth cần biết field username
    public function getAuthIdentifierName()
    {
        return 'Tai_Khoan';
    }

    // Laravel Auth cần biết field password
    public function getAuthPassword()
    {
        return $this->Mat_Khau;
    }
}