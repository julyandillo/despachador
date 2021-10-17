<?php

include_once __DIR__ . '/../../Suscriptor.php';

final class DescatalogaProductoAqua extends Suscriptor
{
    protected string $php_self = self::class;

    protected function lanzaEvento(Evento $evento)
    {
        echo "<br />Código del evento en la clase " . self::class;
    }
}