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
        Schema::create('rotaciones_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rotacion_id')->constrained(table: 'rotacion_stocks');
            $table->foreignId('articulo_id')->constrained(table: 'articulos');
            $table->float('stock_antes')->default(0);
            $table->float('stock_despues');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rotaciones_stocks');
    }
};
