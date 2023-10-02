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
            $table->string('nombre', 255);
            $table->float('cantidad_minima')->default(0);
            $table->foreignId('sub_categoria_id')->constrained(table: 'sub_categorias');
            $table->foreignId('unidad_id')->constrained(table: 'unidades');
            $table->float('costo');
            $table->float('costo_unitario');
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
