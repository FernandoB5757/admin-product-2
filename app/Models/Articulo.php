<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Articulo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'clave',
        'clave_alterna',
        'producto_id',
        'valor_equivalente',
        'descripcion',
        'insumo',
        'usa_embace',
        'precio',
        'precio_embase'
    ];


    /**
     * Pertenece a un producto
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Relacion N - N articulo almacen
     */
    public function stocks(): BelongsToMany
    {
        return $this->belongsToMany(Almacen::class)
            ->withPivot('stock');
    }

    protected function precioFormat(): Attribute
    {
        return Attribute::make(
            get: fn () => '$ ' . number_format($this->precio, 2),
        );
    }

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
        );
    }

    protected function esInsumo(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->insumo ? 'Insumo' : 'Articulo',
        );
    }
}