<?php

namespace App\Helpers;

class ClaveGenerator
{
    /**
     * Genera clave y clave alterna en base a nombre de producto.
     *
     * @param string $texto
     * @return array [string, string]
     */
    public static function generarClaves(string|float|null $texto = ''): array
    {
        if (is_null($texto)) {
            return [
                'clave' => '',
                'clave_alterna' => ''
            ];
        }
        $palabras = explode(" ", $texto);
        $iniciales = array_map(function ($palabra) {
            return strtoupper($palabra[0]);
        }, $palabras);

        $claveAlterna = implode("", $iniciales);

        $clave = $iniciales[0] . strtoupper($palabras[1]) . substr($texto, -3);

        return [
            'clave' => $clave,
            'clave_alterna' => $claveAlterna
        ];
    }
}
