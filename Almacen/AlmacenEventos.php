<?php

include_once __DIR__ . '/../Evento.php';

abstract class AlmacenEventos
{
    protected array $eventos = [];

    protected array $eventosDisponibles = [];

    public function getArrayEventos(): array
    {
        return $this->eventos;
    }

    public function getEvento(string $evento): ?Evento
    {
        if (!array_key_exists($evento, $this->eventosDisponibles)) {
            return null;
        }

        return $this->eventosDisponibles[$evento];
    }

    public function getEventos(): array
    {
        return $this->eventos;
    }

    public function getEventosDisponibles(): array
    {
        $eventos = [];
        foreach ($this->eventosDisponibles as $evento) {
            $eventos[$evento->getTipo()][] = $evento->getNombre();
        }

        return $eventos;
    }

}