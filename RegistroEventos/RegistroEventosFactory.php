<?php

include_once 'RegistroEventos.php';
include_once 'RegistroEventosPorPantalla.php';

class RegistroEventosFactory
{
    private static ?RegistroEventos $instacia = null;

    public static function obtieneRegistroEventos(): RegistroEventos
    {
        if (!self::$instacia) {
            self::$instacia = new RegistroEventosPorPantalla();
        }

        return self::$instacia;
    }
}