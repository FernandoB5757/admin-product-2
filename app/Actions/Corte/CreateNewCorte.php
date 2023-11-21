<?php

namespace App\Actions\Corte;

use App\Models\Caja;
use App\Models\Corte;
use App\Models\Enums\EstatusCaja;
use App\Models\Enums\EstatusCorte;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateNewCorte
{
    use AuthorizesRequests;
    use HandlesAuthorization;

    public function rules(): array
    {
        return [
            'caja_id' => ['required', 'exists:cajas,id'],
            'dinero_apertura' => ['required', 'min:0', 'numeric'],
        ];
    }

    public function attributes(): array
    {
        return [
            'caja_id' => 'caja',
        ];
    }

    /**
     * Crea una nueva corte.
     *
     * @param array $input
     */
    public function create(array $input): Corte
    {
        $caja = Caja::find($input['caja_id']);
        $this->validarCaja($caja);

        $input['fecha_apertura'] = now();
        $input['estatus'] = EstatusCorte::Apertura->value;

        $corte = Corte::create([
            ...$input
        ]);

        $caja->abrir()->save();

        return $corte;
    }

    protected function validarCaja(Caja $caja): bool
    {
        if ($caja->estatus === EstatusCaja::Abierta)
            $this->deny('La caja no esta disponible.');
    }
}
