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
    Schema::table('productos', function (Blueprint $table) {
        if (!Schema::hasColumn('productos', 'cantidad')) {
            $table->integer('cantidad')->default(0);
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('productos', function (Blueprint $table) {
        $table->dropColumn('cantidad');
    });
    }
};
