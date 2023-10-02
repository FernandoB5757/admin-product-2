<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'corte_id',
        'caja_id',
        'sub_total',
        'iva',
        'total',
    ];

    /**
     * Tiene muchos productos
     */
    public function articulos(): HasMany
    {
        return $this->hasMany(VentaArticulo::class, 'venta_id', 'id');
    }
}
