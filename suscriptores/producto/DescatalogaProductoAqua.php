<?php

include_once __DIR__ . '/../../Suscriptor.php';

final class DescatalogaProductoAqua extends Suscriptor
{
    protected function eventoLanzado(Evento $evento)
    {
        echo "<br />Código del evento en la clase " . self::class;
    }
}