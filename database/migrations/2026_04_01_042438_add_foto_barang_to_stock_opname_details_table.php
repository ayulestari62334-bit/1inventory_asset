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
    Schema::table('stock_opname_details', function (Blueprint $table) {
        $table->string('foto_barang')->nullable();
    });
}

public function down()
{
    Schema::table('stock_opname_details', function (Blueprint $table) {
        $table->dropColumn('foto_barang');
    });
}
};
