<?php

include_once 'RegistroEventos.php';

class RegistroEventosPorPantalla extends RegistroEventos
{
    private array $__eventos;

    public function __construct()
    {
        $this->__eventos = [];
    }

    public function registraEventoCapturado(Evento $evento, string $suscriptor): bool
    {
        $this->__eventos[] = $evento;
        $ahora = date('d-m-Y H:i:s');
        echo "<br />-----------------------<br />";
        echo "Suscriptor: " . $suscriptor . ", evento capturado {$evento}, {$ahora}<br />";
        echo "Fecha y hora del evento: {$evento->getTimestamp()}<br />";
        echo "Lanzado desde: {$evento->getLanzador()}, linea {$evento->getLinea()}<br />";
        echo "-----------------------<br />";

        return true;
    }

    public function obtieneUltimoEvento(): Evento
    {
        return $this->__eventos[count($this->__eventos)-1];
    }

    public function obtieneTodosLosEventosDesde(string $fecha): array
    {
        return $this->__eventos;
    }

    public function obtieneTodosLosEventosPorFecha(string $fecha): array
    {
        return $this->__eventos;
    }
}