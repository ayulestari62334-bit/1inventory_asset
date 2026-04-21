<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();

            // Nomor Asset
            $table->string('no_asset')->unique();

            // Relasi Master Data
            $table->foreignId('kategori_id')->constrained('kategori_barang')->cascadeOnDelete();
            $table->foreignId('jenis_id')->constrained('jenis_barang')->cascadeOnDelete();
            $table->foreignId('merk_id')->constrained('mereks')->cascadeOnDelete();
            $table->foreignId('warna_id')->constrained('warnas')->cascadeOnDelete();
            $table->foreignId('lokasi_id')->constrained('lokasi')->cascadeOnDelete();
            $table->foreignId('karyawan_id')->constrained('karyawan')->cascadeOnDelete();

            // Detail Barang
            $table->string('foto')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('jenis_licence')->nullable();
            $table->string('kode_licence')->nullable();

            // Tanggal & Status
            $table->date('tanggal_masuk');
            $table->string('status_barang')->default('Belum STO');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
