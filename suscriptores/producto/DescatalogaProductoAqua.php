<?php

include_once __DIR__ . '/../../Notificable.php';

class DescatalogaProductoAqua implements Notificable
{

    public function notifica(Evento $evento)
    {
        echo "Clase: " . self::class . ", evento capturado<br />";
        var_dump($evento);
        echo "<br />--------------<br />";
    }
}