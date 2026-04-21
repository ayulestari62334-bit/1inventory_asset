<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_opname_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stock_opname_id')
                  ->constrained('stock_opnames')
                  ->cascadeOnDelete();

            $table->foreignId('barang_id')
                  ->constrained('barang')
                  ->cascadeOnDelete();

            $table->integer('stok_sistem');
            $table->integer('stok_fisik')->nullable();
            $table->enum('status', ['pending', 'done'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_opname_details', function (Blueprint $table) {
            $table->dropConstrainedForeignId('stock_opname_id');
            $table->dropConstrainedForeignId('barang_id');
        });

        Schema::dropIfExists('stock_opname_details');
    }
};
