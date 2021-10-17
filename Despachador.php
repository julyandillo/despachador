<?php

include_once 'Almacen/FactoryAlmacen.php';
include_once 'Suscriptor.php';

class Despachador
{
    private static ?Despachador $instancia = null;

    private AlmacenEventos $almacenEventos;

    private function __construct()
    {
        $this->almacenEventos = FactoryAlmacen::getAlmacen();
    }

    public static function lanzaEvento(string $eventoParalanzar, array $parametros)
    {
        if (!self::$instancia) {
            self::$instancia = new self();
        }

        if (!Evento::esValido($eventoParalanzar)) {
            echo "ERROR: el evento '{$eventoParalanzar}' no es válido";
            return;
        }

        $evento = self::$instancia->almacenEventos->getEvento($eventoParalanzar);
        if (!$evento) {
            echo "ERROR: El evento '{$eventoParalanzar}' no está entre los disponibles";
            return;
        }

        $diferencias = array_diff($evento->getParametrosObligatorios(), array_keys($parametros));
        if (!empty($diferencias)) {
            echo "ERROR: para que el evento sea lanzado se deben pasar los siguientes parametros: <br />" .
                implode(',', $diferencias);

            return;
        }

        $evento
            ->setParametros($parametros)
            // obtiene el archivo desde el cual se lanza el evento
            ->setLanzador(debug_backtrace()[0]['file'])
            ->setLinea(debug_backtrace()[0]['line']);

        foreach ($evento->getSuscriptores() as $suscriptor) {
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