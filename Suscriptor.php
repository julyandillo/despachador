<?php

abstract class Suscriptor
{
    const PATH_SUSCRIPTORES = 'suscriptores';

    private Evento $evento;

    protected string $nombre_clase;  // para poder saber de que clase hija se esta ejecutando

    public static function getInstanciaPorNombre(string $nombreSuscriptor, string $tipoEvento): ?self
    {
        if (!file_exists(self::PATH_SUSCRIPTORES . '/' . $tipoEvento . '/' . $nombreSuscriptor . '.php')) {
            echo "ERROR: No se encuentra la clase del suscriptor en la ruta adecuada<br />";
            return null;
        }

        include_once self::PATH_SUSCRIPTORES . '/' . $tipoEvento . '/' . $nombreSuscriptor . '.php';

        try {
            $reflector = new ReflectionClass($nombreSuscriptor);

        } catch (ReflectionException $ex) {
            echo "ERROR: No se ha podido instanciar el suscriptor<br />" . $ex->getMessage();
            return null;
        }

        if (!$reflector->isSubclassOf('Suscriptor')) {
            echo "ERROR: El suscriptor '{$nombreSuscriptor}' no es una subclase de la clase Suscriptor<br />";
            return null;
        }

        return $reflector->newInstance();
    }

    public function notificaEvento(Evento $evento)
    {
        $this->evento = $evento;
        $this->guardaRegistroEventos();

        $this->lanzaEvento($evento);
    }
    private function guardaRegistroEventos()
    {
        //file_put_contents(__DIR__ . '/registro_eventos.log', $this->evento . PHP_EOL, FILE_APPEND);
        $ahora = date('d-m-Y H:i:s');
        echo "<br />-----------------------<br />";
        echo "Suscriptor: " . $this->nombre_clase . ", evento capturado {$this->evento}, {$ahora}<br />";
        echo "Fecha y hora del evento: {$this->evento->getTimestamp()}<br />";
        echo "Lanzado desde: {$this->evento->getLanzador()}, linea {$this->evento->getLinea()}<br />";
        echo "-----------------------<br />";
    }

    protected abstract function lanzaEvento(Evento $evento);
}