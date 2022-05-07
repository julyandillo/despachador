<?php

include_once 'RegistroEventos/RegistroEventosFactory.php';

abstract class Suscriptor
{
    const PATH_SUSCRIPTORES = 'suscriptores';

    private string $nombre_clase;  // para poder saber de que clase hija se esta ejecutando

    public static function getInstanciaPorNombre(string $nombreSuscriptor, string $tipoEvento): ?object
    {
        if (!file_exists(self::PATH_SUSCRIPTORES . '/' . $tipoEvento . '/' . $nombreSuscriptor . '.php')) {
            echo "ERROR: No se encuentra la clase del suscriptor en la ruta adecuada<br />";
            return null;
        }

        include_once self::PATH_SUSCRIPTORES . '/' . $tipoEvento . '/' . $nombreSuscriptor . '.php';

        try {
            $reflector = new ReflectionClass($nombreSuscriptor);

            if (!$reflector->isSubclassOf('Suscriptor')) {
                echo "ERROR: El suscriptor '{$nombreSuscriptor}' no es una subclase de la clase Suscriptor<br />";
                return null;
            }

            $suscriptor = $reflector->newInstance();
            $suscriptor->estableceNombreClaseSuscriptor($reflector->getName());

            return $suscriptor;

        } catch (ReflectionException $ex) {
            echo "ERROR: No se ha podido instanciar el suscriptor<br />" . $ex->getMessage();
            return null;
        }

    }

    private function estableceNombreClaseSuscriptor(string $clase)
    {
        $this->nombre_clase = $clase;
    }

    public function notificaEvento(Evento $evento)
    {
        $this->guardaRegistroDeEventos($evento);
        $this->eventoLanzado($evento);
    }

    private function guardaRegistroDeEventos(Evento $evento)
    {
        //file_put_contents(__DIR__ . '/registro_eventos.log', $this->evento . PHP_EOL, FILE_APPEND);
        $registroEventos = RegistroEventosFactory::obtieneRegistroEventos();
        $registroEventos->registraEventoCapturado($evento, $this->nombre_clase);
    }

    public function __toString(): string
    {
        return $this->nombre_clase;
    }

    protected abstract function eventoLanzado(Evento $evento);
}