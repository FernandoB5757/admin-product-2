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
        Schema::create('venta_articulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained(table: 'ventas');
            $table->foreignId('articulo_id')->constrained(table: 'articulos');
            $table->float('precio', places: 2);
            $table->integer('cantidad');
            $table->boolean('con_embace')->default(false);
            $table->timestamps();
        });
        /*
        'venta_id',
        'articulo_id',
        'precio', */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_articulos');
    }
};
