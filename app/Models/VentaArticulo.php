<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VentaArticulo extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'articulo_id',
        'precio',
        'precio',
        'cantidad',
        'con_embace'
    ];

    /**
     * Pertenece a un producto
     */
    public function articulo(): BelongsTo
    {
        return $this->belongsTo(Articulo::class, 'articulo_id', 'id');
    }

    /**
     * Pertenece a una venta
     */
    public function venta(): BelongsTo
    {
        return $this->belongsTo(Articulo::class, 'venta_id', 'id');
    }
}
