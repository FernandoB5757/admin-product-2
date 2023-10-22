<?php

namespace App\Actions\Almacen;

use App\Models\AlmacenArticulo;
use App\Models\Enums\TipoRotacion;
use App\Models\RotacionesStocks;
use App\Models\RotacionStocks;

class UpdateStock
{
    /**
     * Crea o edita stocks del almacen.
     *
     * @param array $input
     */
    public static function updateOrCreate(array $data): AlmacenArticulo
    {
        $articuloAlmacen = AlmacenArticulo::where('articulo_id', $data['articulo_id'])
            ->where('almacen_id', $data['almacen_id'])->first();

        if ($articuloAlmacen) {
            $oldStock = $articuloAlmacen->stock;
            $articuloAlmacen->stock = $data['stock'];
            self::createRotation($articuloAlmacen, oldStock: $oldStock);
            $articuloAlmacen->save();
            return $articuloAlmacen;
        }

        self::createRotation($articuloAlmacen);
        return AlmacenArticulo::create($data);
    }

    public static function createRotation($register, int $almacenId = 1, int $oldStock = 0)
    {
        $rotacion = RotacionStocks::create([
            'tipo' => TipoRotacion::Ajuste,
            'user_id' => auth()->user()->id,
            'almacen_id' => $almacenId,
            // 'venta_id',
            'descripcion' => TipoRotacion::Ajuste->descripcion(),
        ]);

        RotacionesStocks::create([
            'rotacion_id' =>  $rotacion->id,
            'articulo_id' => $register->articulo_id,
            'stock_antes' => $oldStock,
            'stock_despues' => $register->stock,
        ]);
    }
}
