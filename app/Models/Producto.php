<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    //protected $hidden  = ['id'];

    protected $fillable =  [
        'nombre',
        'cantidad_minima',
        'sub_categoria_id',
        'unidad_id',
        'costo_unitario',
        'costo'
    ];

    /**
     * Tiene muchos articulos
     */
    public function articulos(): HasMany
    {
        return $this->hasMany(Articulo::class);
    }

    /**
     * Pertenece a una subcategoria
     */
    public function subcategoria(): BelongsTo
    {
        return $this->belongsTo(SubCategoria::class, 'sub_categoria_id', 'id');
    }

    /**
     * Pertenece a una unidad de medida
     */
    public function unidad(): BelongsTo
    {
        return $this->belongsTo(Unidad::class);
    }

    protected function costoFormat(): Attribute
    {
        return Attribute::make(
            get: fn () => '$' . number_format($this->costo, 2),
        );
    }

    protected function costounitarioFormat(): Attribute
    {
        return Attribute::make(
            get: fn () => '$' . number_format($this->costo_unitario, 2),
        );
    }


    protected function tieneInsumo(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->articulos()->where('insumo', true)->count() === 1,
        );
    }


    public function unidadNombre(): Attribute
    {
        return Attribute::make(
            get: fn () =>  strtolower($this->unidad->nombre),
        );
    }
}
