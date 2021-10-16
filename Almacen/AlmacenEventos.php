<?php

include_once __DIR__ . '/../Evento.php';

abstract class AlmacenEventos
{
    protected array $eventos = [];

    protected array $eventosDisponibles = [];

    protected array $suscriptores = [];

    public function getTodosSuscriptores(): array
    {
        return $this->suscriptores;
    }

    public function getArraySuscriptoresDelEvento(string $evento): array
    {
        return $this->suscriptores[$evento];
    }

    public function getArrayEventos(): array
    {
        return $this->eventos;
    }

    public function eventoDisponible(string $evento): bool
    {
        if (!Evento::esValido($evento)) {
            return false;
        }

        return in_array($evento, $this->eventosDisponibles);
    }

    public function getEventos(): array
    {
        return $this->eventos;
    }

    public function getEventosDisponibles(): array
    {
        $eventos = [];
        foreach ($this->eventosDisponibles as $evento) {
            $tipo = Evento::getTipoEvento($evento);
            $eventos[$tipo][] = Evento::getNombreEvento($evento);
        }

        return $eventos;
    }

}