<?php

class Evento
{
    public static function esValido(string $nombreEvento): bool
    {
        return strpos($nombreEvento, '.') !== false;
    }

    public static function obtenerTipoEvento($nombreEvento): string
    {
        return strtolower(explode('.', $nombreEvento)[0]);
    }

}