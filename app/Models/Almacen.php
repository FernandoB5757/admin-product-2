<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacenes';

    protected $fillable = [
        'nombre',
        'ubicacion',
        'descripcion'
    ];

    public function articulos(): BelongsToMany
    {
        return $this->belongsToMany(Articulo::class)->using(ArticuloAlmacen::class)->withPivot('stock');
    }
}
