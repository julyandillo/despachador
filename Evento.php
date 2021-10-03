<?php

class Evento
{
    public static function esValido(string $nombreEvento): bool
    {
        return strpos($nombreEvento, '_') !== false;
    }

    public static function obtenerTipoEvento($nombreEvento): string
    {
        return strtolower(explode('_', $nombreEvento)[0]);
    }

}