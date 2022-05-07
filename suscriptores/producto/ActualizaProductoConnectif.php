<?php

include_once __DIR__ . '/../../Suscriptor.php';

final class ActualizaProductoConnectif extends Suscriptor
{
    protected function lanzaEvento(Evento $evento)
    {
        echo "<br />Código del evento en la clase " . self::class;
    }
}