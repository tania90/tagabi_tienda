<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up(): void
{
    Schema::table('ventas', function (Blueprint $table) {
        if (!Schema::hasColumn('ventas', 'fecha')) {
            $table->timestamp('fecha')->default(DB::raw('CURRENT_TIMESTAMP'));
        } else {
            $table->timestamp('fecha')->default(DB::raw('CURRENT_TIMESTAMP'))->change();
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->date('fecha')->nullable()->change();
        });
    }
};
