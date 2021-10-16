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
            ->setLlamador(debug_backtrace()[0]['file'])
            ->setLinea(debug_backtrace()[0]['line']);

        foreach (self::$instancia->almacenEventos->getArraySuscriptoresDelEvento($eventoParalanzar) as $suscriptor) {
            if (!($creaInstanciaDelSuscriptor = self::$instancia->creaInstanciaDelSuscriptor($suscriptor, $evento->getTipo()))) {
                continue;
            }

            $creaInstanciaDelSuscriptor->notifica($evento);
        }
    }

    public static function getInstancia(): self
    {
        if (!self::$instancia) {
            self::$instancia = new self();
        }

        return self::$instancia;
    }

    public function creaInstanciaDelSuscriptor(string $nombreClaseSuscriptor, string $tipoEvento): ?Notificable
    {
        if (!file_exists(self::PATH_SUSCRIPTORES . '/' . $tipoEvento . '/' . $nombreClaseSuscriptor . '.php')) {
            echo "ERROR: No se encuentra la clase del suscriptor en la ruta adecuada<br />";
            return null;
        }

        include_once self::PATH_SUSCRIPTORES . '/' . $tipoEvento . '/' . $nombreClaseSuscriptor . '.php';

        try {
            $reflector = new ReflectionClass($nombreClaseSuscriptor);

        } catch (ReflectionException $ex) {
            echo "ERROR: No se ha podido instanciar el suscriptor<br />" . $ex->getMessage();
            return null;
        }

        if (!$reflector->implementsInterface('Notificable')) {
            echo "ERROR: El suscriptor '{$nombreClaseSuscriptor}' no implementa la interfaz notificable<br />";
            return null;
        }

        return $reflector->newInstance();
    }

    public function getEventosDisponibles(): array
    {
        return $this->almacenEventos->getEventosDisponibles();
    }

}