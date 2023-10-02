<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class SubCategoria extends Model
{
    use HasFactory;

    protected $fillable = [
        "nombre",
        "descripcion",
        "categoria_id"
    ];

    public static function getOptions(int|string|null $categoriaId = null): Collection
    {
        $query = self::query();
        if ($categoriaId !== null)
            $query->where('categoria_id', $categoriaId);

        return $query->pluck('nombre', 'id');
    }

    /**
     * Pertenece a una categoria
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Tiene muchos productos
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }
}
