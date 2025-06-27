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
        if (!Schema::hasColumn('ventas', 'fecha')) {
            $table->date('fecha')->nullable()->after('cliente_id');
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('ventas', function (Blueprint $table) {
        $table->dropColumn('fecha');
    });
    }
};
