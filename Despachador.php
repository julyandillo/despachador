<?php

include_once 'Almacen/FactoryAlmacen.php';

class Despachador
{
    const SUSCRIPTORES = 'suscriptores';

    private static ?Despachador $instance = null;

    public AlmacenEventos $almacenEventos;

    private function __construct()
    {
        $this->almacenEventos = FactoryAlmacen::getAlmacen();
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
            if (!($creaInstanciaDelSuscriptor = self::$instance->creaInstanciaDelSuscriptor($observador, $evento))) {
                continue;
            }

            $creaInstanciaDelSuscriptor->notifica($evento, $parametros);
        }
    }

    public function creaInstanciaDelSuscriptor(string $nombreClase, string $evento): ?Notificable
    {
        $tipoEvento = explode('_', $evento)[0];

        if (!file_exists(self::SUSCRIPTORES . '/' . Evento::obtenerTipoEvento($evento) . '/' . $nombreClase . '.php')) {
            echo "ERROR: No se encuentra el fichero del susciptor en la ruta adecuada<br />";
            return null;
        }

        include_once self::SUSCRIPTORES . '/' . Evento::obtenerTipoEvento($evento) . '/' . $nombreClase . '.php';

        try {
            $reflector = new ReflectionClass($nombreClase);

        } catch (ReflectionException $ex) {
            echo "ERROR: No se ha podido instanciar el suscriptor<br />" . $ex->getMessage();
            return null;
        }

        if (!$reflector->implementsInterface('Notificable')) {
            echo "ERROR: El suscriptor '{$nombreClase}' no implementa la interfaz notificable<br />";
            return null;
        }

        return $reflector->newInstance();
    }

}