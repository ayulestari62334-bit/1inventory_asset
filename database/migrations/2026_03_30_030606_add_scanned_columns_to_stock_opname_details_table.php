<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_opname_details', function (Blueprint $table) {
            $table->foreignId('scanned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('scanned_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('stock_opname_details', function (Blueprint $table) {
            $table->dropForeign(['scanned_by']);
            $table->dropColumn(['scanned_by', 'scanned_at']);
        });
    }
};