<?php

include_once 'Almacen/FactoryAlmacen.php';
include_once 'Suscriptor.php';

class Despachador
{
    private static ?Despachador $instancia = null;

    public AlmacenEventos $almacenEventos;

    private function __construct()
    {
        $this->almacenEventos = FactoryAlmacen::getAlmacen();
    }

    public static function lanzaEvento(string $eventoParalanzar, array $parametros)
    {
        if (!self::$instancia) {
            self::$instancia = new self();
        }

        if (!self::$instancia->almacenEventos->eventoDisponible($eventoParalanzar)) {
            echo "ERROR: El evento '{$eventoParalanzar}' no es válido o no está entre los disponibles";
            return null;
        }

        $evento = new Evento($eventoParalanzar);
        $evento
            ->setParametros($parametros)
            // obtiene el archivo desde el cual se lanza el evento
            ->setLanzador(debug_backtrace()[0]['file'])
            ->setLinea(debug_backtrace()[0]['line']);

        foreach (self::$instancia->almacenEventos->getArraySuscriptoresDelEvento($eventoParalanzar) as $suscriptor) {
            if (!($instanciaDelSuscriptor = Suscriptor::getInstanciaPorNombre($suscriptor, $evento->getTipo()))) {
                continue;
            }

            $instanciaDelSuscriptor->notificaEvento($evento);
        }
    }

    public static function getInstancia(): self
    {
        if (!self::$instancia) {
            self::$instancia = new self();
        }

        return self::$instancia;
    }

    public function getEventosDisponibles(): array
    {
        return $this->almacenEventos->getEventosDisponibles();
    }

}