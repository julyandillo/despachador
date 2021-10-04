<?php

include_once 'AlmacenEventos.php';
include_once 'AlmacenEventosJSON.php';

class FactoryAlmacen
{
    public static function getAlmacen(): AlmacenEventos
    {
        return new AlmacenEventosJSON();
    }
}