<?php

include_once __DIR__ . '/../../Notificable.php';

class DescatalogaProductoAqua implements Notificable
{

    public function notifica(array $parametros)
    {
        echo 'Descatalogando producto en AQUA...<br />';
    }
}