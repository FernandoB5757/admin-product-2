<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlmacenArticulo extends Model
{
    protected $table = 'almacen_articulo';

    protected $fillable  = [
        'articulo_id',
        'almacen_id',
        'stock'
    ];

    /**
     * Pertenece a un producto
     */
    public function articulo(): BelongsTo
    {
        return $this->belongsTo(Articulo::class, 'articulo_id', 'id');
    }

    public function scopearticulosenAlmacen(Builder $query, int $almacenId, ?array $articulosIds = null): void
    {
        $query->where('almacen_id', $almacenId);
        if ($articulosIds !== null)
            $query->whereIn('articulo_id', $articulosIds);
    }

    public function scopearticuloenAlmacen(Builder $query, int $almacenId, int $articuloId): void
    {
        $query->where('almacen_id', $almacenId)->where('articulo_id', $articuloId);
    }
}
