<?php

class Evento
{
    public static function esValido(string $evento): bool
    {
        return strpos($evento, '.') !== false;
    }

    public static function getTipoEvento(string $evento): string
    {
        return strtolower(explode('.', $evento)[0]);
    }

    public static function getNombreEvento(string $evento): string
    {
        return explode('.', $evento)[1];
    }

}