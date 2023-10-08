<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Query\Expression;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255)->unique();
            $table->string('clave', 20)->unique();
            $table->string('clave_alterna', 10)->unique();
            $table->foreignId('producto_id')->constrained(table: 'productos');
            $table->json('imagenes')->default(new Expression('(JSON_ARRAY())'));
            $table->float('valor_equivalente');
            $table->float('precio');
            $table->boolean('usa_embace')->default(true);
            $table->boolean('insumo')->default(false);
            $table->float('precio_embase')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
