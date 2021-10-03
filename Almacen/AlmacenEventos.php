<?php

abstract class AlmacenEventos
{
    protected array $eventos = [];

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

    public function existeEvento(string $evento): bool
    {
        if (Evento::esValido($evento)) {
            return in_array($evento, $this->eventos);
        }

        return false;
    }

}