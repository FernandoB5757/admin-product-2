<?php

namespace App\Models;

use App\Models\Enums\EstatusUnidad;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unidad extends Model
{
    use HasFactory;
    protected $table = 'unidades';

    protected $fillable = [
        'clave',
        'nombre',
        'descripcion',
        'estatus'
    ];

    protected $casts = [
        'estatus' => EstatusUnidad::class,
    ];

    protected $withCount = [
        'productos'
    ];

    /**
     * Tiene muchos productos
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }

    public function hasProductos(): bool
    {
        return $this->productos_count > 0;
    }

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }
}
