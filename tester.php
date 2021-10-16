<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'Despachador.php';

$despachador = Despachador::getInstancia();

print_r($despachador->getEventosDisponibles());
$despachador->lanzaEvento('producto.descatalogado', ['sku' => '123-1234']);