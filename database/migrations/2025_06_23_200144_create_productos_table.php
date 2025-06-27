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
    Schema::create('productos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->decimal('precio', 10, 2);
        $table->integer('cantidad');  // Cambié 'stock' a 'cantidad'
        $table->decimal('precio_costo', 10, 2)->nullable()->after('cantidad');
        $table->decimal('precio_venta', 10, 2)->nullable()->after('precio_costo');
        $table->integer('stock_minimo')->default(1)->after('cantidad');
        $table->string('imagen')->nullable()->after('color');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
