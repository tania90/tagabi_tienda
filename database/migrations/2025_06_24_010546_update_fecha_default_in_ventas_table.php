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
    Schema::table('ventas', function (Blueprint $table) {
        $table->date('fecha')->default(DB::raw('CURRENT_DATE'))->change();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('ventas', function (Blueprint $table) {
        $table->date('fecha')->nullable()->default(null)->change();
    });
    }
};
