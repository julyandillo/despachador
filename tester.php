<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'Despachador.php';

Despachador::lanzaEvento('producto.cambia_precio', ['sku' => '123-1234']);