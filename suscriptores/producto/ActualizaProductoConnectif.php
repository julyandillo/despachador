<?php

include_once __DIR__ . '/../../Notificable.php';

class ActualizaProductoConnectif implements Notificable
{
    public function notifica(Evento $evento)
    {
        echo "Clase: " . self::class . ", evento capturado, {$evento}";
        echo "<br />--------------<br />";
    }
}