<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('karyawan', function (Blueprint $table) {
        $table->unique('id_karyawan');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('id_karyawan', function (Blueprint $table) {
            //
        });
    }
};
