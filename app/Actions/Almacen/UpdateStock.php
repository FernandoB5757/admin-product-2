<?php

namespace App\Actions\Almacen;

use App\Models\AlmacenArticulo;
use App\Models\Enums\TipoRotacion;
use App\Models\RotacionesStocks;
use App\Models\RotacionStocks;
use Illuminate\Support\Facades\DB;

class UpdateStock
{
    /**
     * Crea o edita stocks del almacen.
     *
     * @param array $input
     */
    public static function updateOrCreate(array $data): AlmacenArticulo
    {
        $articuloAlmacen = AlmacenArticulo::findRegister($data['articulo_id'], $data['almacen_id']);

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

    /**
     * Crea o edita stocks del almacen.
     *
     * @param array $input
     */
    public static function updateOrCreateMultiple(array $ajustes, array $rotacionData, int $almacenId = 1): void
    {
        $rotaciones = [];
        DB::beginTransaction();
        try {
            foreach ($ajustes as $key => $data) {
                $articuloAlmacen = AlmacenArticulo::findRegister($data['articulo_id'], $almacenId);
                $rotacion = new RotacionesStocks([
                    'articulo_id' => $data['articulo_id'],
                    'stock_despues' => $data['stock']
                ]);

                if ($articuloAlmacen) {
                    $rotacion->stock_antes = $articuloAlmacen->stock;
                    $articuloAlmacen->stock = $data['stock'];
                    $articuloAlmacen->save();
                } else {
                    $rotacion->stock_antes = 0;
                    AlmacenArticulo::create([
                        'articulo_id' => $data['articulo_id'],
                        'almacen_id' => $almacenId,
                        'stock' => $data['stock']
                    ]);
                }
                $rotaciones[] = $rotacion;
            }
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }
        DB::commit();

        self::createRotationes($rotaciones, $rotacionData);
    }

    public static function createRotationes(array $rotaciones, array $rotacionData, int $almacenId = 1)
    {
        if (empty($rotaciones)) {
            return;
        }
        $rotacion = RotacionStocks::create($rotacionData);
        $rotacion->rotaciones()->saveMany($rotaciones);
    }
}
