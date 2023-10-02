<?php

namespace App\Models;

use App\Models\Enums\EstatusCaja;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'estatus'
    ];

    protected $casts = [
        'estatus' => EstatusCaja::class,
    ];


    public function scopeDisponibles(Builder $query): void
    {
        $query->where('estatus', EstatusCaja::Cerrada->value);
    }

    public function abrir(): self
    {
        $this->estatus = EstatusCaja::Abierta;
        return $this;
    }
}
