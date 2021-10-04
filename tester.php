<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'Despachador.php';


Despachador::lanzaEvento('PRODUCTO_DESCATALOGADO', ['sku' => '123-1234']);