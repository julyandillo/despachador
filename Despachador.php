<?php

include_once 'Almacen/FactoryAlmacen.php';

class Despachador
{
    const PATH_SUSCRIPTORES = 'suscriptores';

    private static ?Despachador $instancia = null;

    public AlmacenEventos $almacenEventos;

    private function __construct()
    {
        $this->almacenEventos = FactoryAlmacen::getAlmacen();
    }

    public static function lanzaEvento(string $evento, array $parametros)
    {
        if (!self::$instancia) {
            self::$instancia = new self();
        }

        if (!self::$instancia->almacenEventos->eventoDisponible($evento)) {
            echo "ERROR: El evento '{$evento}' no es válido o no está entre los disponibles";
            return null;
        }

        foreach (self::$instancia->almacenEventos->getArraySuscriptoresDelEvento($evento) as $observador) {
            if (!($creaInstanciaDelSuscriptor = self::$instancia->creaInstanciaDelSuscriptor($observador, $evento))) {
                continue;
            }

            $creaInstanciaDelSuscriptor->notifica($evento, $parametros);
        }
    }

    public static function getInstancia(): self
    {
        if (!self::$instancia) {
            self::$instancia = new self();
        }

        return self::$instancia;
    }

    public function creaInstanciaDelSuscriptor(string $nombreClase, string $evento): ?Notificable
    {
        if (!file_exists(self::PATH_SUSCRIPTORES . '/' . Evento::getTipoEvento($evento) . '/' . $nombreClase . '.php')) {
            echo "ERROR: No se encuentra la clase del suscriptor en la ruta adecuada<br />";
            return null;
        }

        include_once self::PATH_SUSCRIPTORES . '/' . Evento::getTipoEvento($evento) . '/' . $nombreClase . '.php';

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

    public function getEventosDisponibles(): array
    {
        return $this->almacenEventos->getEventosDisponibles();
    }

}