<?php

include_once __DIR__ . '/../../Notificable.php';

class ActualizaProductoConnectif implements Notificable
{
    public function notifica(string $evento, array $parametros)
    {
        echo "Clase: " . self::class . ", evento capturado, {$evento}";
        echo "<br />--------------<br />";
    }
}