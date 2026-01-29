<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuanTriVienTable extends Migration
{
    public function up(): void
    {
        Schema::create('quan_tri_vien', function (Blueprint $table) {
            $table->id('Ma_Admin');

            $table->string('Ho_Ten');
            $table->string('Tai_Khoan')->unique();
            $table->string('Mat_Khau');
            $table->string('Email')->nullable();
            $table->string('So_Dien_Thoai')->nullable();

            // Cho Auth
            $table->rememberToken();

            // Ngày tạo
            $table->timestamp('Ngay_Tao')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quan_tri_vien');
    }
}
