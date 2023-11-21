<?php

namespace App\Models;

use App\Models\Enums\EstatusCorte;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Corte extends Model
{
    use HasFactory;

    protected $fillable = [
        'caja_id',
        'dinero_apertura',
        'dinero_cierre',
        'fecha_apertura',
        'fecha_cierre',
        'estatus'
    ];

    protected $casts = [
        'estatus' => EstatusCorte::class
    ];


    public function caja(): BelongsTo
    {
        return $this->belongsTo(Caja::class, 'caja_id');
    }

    protected function aperturaFormat(): Attribute
    {
        return Attribute::make(
            get: fn () => '$' . number_format($this->dinero_apertura, 2),
        );
    }

    protected function cierreFormat(): Attribute
    {
        return Attribute::make(
            get: fn () => '$' . number_format($this->dinero_cierre, 2),
        );
    }
}
