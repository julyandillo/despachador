<?php

include_once __DIR__ . '/../../Notificable.php';

class ActualizaProductoConnectif implements Notificable
{
    public function notifica(array $parametros)
    {
        print_r($parametros);
    }
}