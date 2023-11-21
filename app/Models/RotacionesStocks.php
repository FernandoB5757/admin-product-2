<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RotacionesStocks extends Model
{
    use HasFactory;

    protected $table = 'rotaciones_stocks';

    protected $fillable = [
        'rotacion_id',
        'articulo_id',
        'stock_antes',
        'stock_despues',
    ];

    public function rotacion(): BelongsTo
    {
        return $this->belongsTo(RotacionStocks::class, 'rotacion_id');
    }

    public function articulo(): BelongsTo
    {
        return $this->belongsTo(Articulo::class, 'articulo_id');
    }

    protected function fecha(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->created_at)->format('d/m/Y g:i:s a')
        );
    }
}
