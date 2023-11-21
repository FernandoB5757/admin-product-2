<?php

namespace App\Models;

use App\Models\Enums\TipoRotacion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RotacionStocks extends Model
{
    use HasFactory;

    protected $table = 'rotacion_stocks';

    protected $fillable = [
        'tipo',
        'user_id',
        'almacen_id',
        // 'venta_id',
        'descripcion'
    ];

    protected $casts = [
        'tipo' => TipoRotacion::class,
    ];

    public function rotaciones(): HasMany
    {
        return $this->hasMany(RotacionesStocks::class, 'rotacion_id');
    }

    public function almacen(): BelongsTo
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function fecha(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->created_at)->format('d/m/Y g:i:s a')
        );
    }
}
