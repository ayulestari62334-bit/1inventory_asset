<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {

            // ========================
            // TAMBAH COLUMN (JIKA BELUM ADA)
            // ========================

            if (!Schema::hasColumn('barang', 'merek_id')) {
                $table->unsignedBigInteger('merek_id')->nullable()->after('jenis_id');
            }

            if (!Schema::hasColumn('barang', 'warna_id')) {
                $table->unsignedBigInteger('warna_id')->nullable()->after('merek_id');
            }

            if (!Schema::hasColumn('barang', 'lokasi_id')) {
                $table->unsignedBigInteger('lokasi_id')->nullable()->after('warna_id');
            }

            if (!Schema::hasColumn('barang', 'karyawan_id')) {
                $table->unsignedBigInteger('karyawan_id')->nullable()->after('lokasi_id');
            }
        });

        // ========================
        // TAMBAH FOREIGN KEY (AMAN)
        // ========================

        Schema::table('barang', function (Blueprint $table) {

            // cek apakah foreign key sudah ada
            $foreignKeys = collect(DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_NAME = 'barang'
                AND TABLE_SCHEMA = DATABASE()
            "))->pluck('CONSTRAINT_NAME')->toArray();

            if (!in_array('barang_merek_id_foreign', $foreignKeys)) {
                $table->foreign('merek_id')
                      ->references('id')
                      ->on('mereks')
                      ->cascadeOnDelete();
            }

            if (!in_array('barang_warna_id_foreign', $foreignKeys)) {
                $table->foreign('warna_id')
                      ->references('id')
                      ->on('warnas')
                      ->cascadeOnDelete();
            }

            if (!in_array('barang_lokasi_id_foreign', $foreignKeys)) {
                $table->foreign('lokasi_id')
                      ->references('id')
                      ->on('lokasis')
                      ->cascadeOnDelete();
            }

            if (!in_array('barang_karyawan_id_foreign', $foreignKeys)) {
                $table->foreign('karyawan_id')
                      ->references('id')
                      ->on('karyawans')
                      ->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {

            // Drop foreign jika ada
            if (Schema::hasColumn('barang', 'merek_id')) {
                $table->dropForeign(['merek_id']);
            }

            if (Schema::hasColumn('barang', 'warna_id')) {
                $table->dropForeign(['warna_id']);
            }

            if (Schema::hasColumn('barang', 'lokasi_id')) {
                $table->dropForeign(['lokasi_id']);
            }

            if (Schema::hasColumn('barang', 'karyawan_id')) {
                $table->dropForeign(['karyawan_id']);
            }

            // Drop column jika ada
            if (Schema::hasColumn('barang', 'merek_id')) {
                $table->dropColumn('merek_id');
            }

            if (Schema::hasColumn('barang', 'warna_id')) {
                $table->dropColumn('warna_id');
            }

            if (Schema::hasColumn('barang', 'lokasi_id')) {
                $table->dropColumn('lokasi_id');
            }

            if (Schema::hasColumn('barang', 'karyawan_id')) {
                $table->dropColumn('karyawan_id');
            }
        });
    }
};
