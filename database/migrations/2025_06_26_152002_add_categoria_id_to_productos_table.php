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
            // Primero agregamos la columna (nullable por el onDelete('set null'))
            $table->unsignedBigInteger('categoria_id')->nullable()->after('color');

            // Luego agregamos la clave foránea
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
        });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropColumn('categoria_id');
        });
    }
};
