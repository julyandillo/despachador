<?php

class Despachador
{
    const SUSCRIPTORES = 'suscriptores';

    private static ?Despachador $instance = null;

    public AlmacenEventos $almacenEventos;

    private function __construct()
    {
        $this->almacenEventos = new AlmacenEventosJSON();
    }

    public static function lanzaEvento(string $evento, array $parametros)
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        if (!self::$instance->almacenEventos->existeEvento($evento)) {
            echo "ERROR: El evento '{$evento}' no es válido o no está entre los disponibles";
            return null;
        }

        foreach (self::$instance->almacenEventos->getArraySuscriptoresDelEvento($evento) as $observador) {
            if (!($instanciaDelObservador = self::$instance->creaInstanciaDelSuscriptor($observador, $evento))) {
                continue;
            }

            $instanciaDelObservador->notifica($parametros);
        }
    }

    public function creaInstanciaDelSuscriptor(string $nombreClase, string $evento): ?Notificable
    {
        $tipoEvento = explode('_', $evento)[0];

        if (!file_exists(self::SUSCRIPTORES . '/' . Evento::obtenerTipoEvento($evento) . '/' . $nombreClase . '.php')) {
            return null;
        }

        include_once self::SUSCRIPTORES . '/' . Evento::obtenerTipoEvento($evento) . '/' . $nombreClase . '.php';

        try {
            $reflector = new ReflectionClass($nombreClase);

        } catch (ReflectionException $ex) {
            echo "ERROR: No se ha podido instanciar el suscriptor\n" . $ex->getMessage();
            return null;
        }

        if (!$reflector->implementsInterface('Notificable')) {
            echo "ERROR: El suscriptor '{$nombreClase}' no implementa la interfaz notificable\n";
            return null;
        }

        return $reflector->newInstance();
    }

}