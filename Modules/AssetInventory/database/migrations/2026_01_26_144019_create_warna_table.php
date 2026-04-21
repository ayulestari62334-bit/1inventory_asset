<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('warnas', function (Blueprint $table) {
    $table->id();
    $table->string('kode_warna')->unique();
    $table->string('nama_warna');
    $table->string('hex_warna')->nullable();
    $table->text('keterangan')->nullable();
    $table->timestamps();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('warnas');
    }
};
