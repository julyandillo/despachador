<?php

abstract class Suscriptor
{
    private Evento $evento;

    protected string $php_self;  // para poder saber de que clase hija se esta ejecutando

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
        echo "Suscriptor: " . $this->php_self . ", evento capturado {$this->evento}, {$ahora}<br />";
        echo "Fecha y hora del evento: {$this->evento->getTimestamp()}<br />";
        echo "Lanzado desde: {$this->evento->getLanzador()}, linea {$this->evento->getLinea()}<br />";
        echo "-----------------------<br />";
    }

    protected abstract function lanzaEvento(Evento $evento);
}