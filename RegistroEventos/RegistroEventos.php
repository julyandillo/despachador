<?php

abstract class RegistroEventos
{
    public abstract function registraEventoCapturado(Evento $evento, string $suscriptor): bool;

    public abstract function obtieneUltimoEvento(): Evento;

    public abstract function obtieneTodosLosEventosDesde(string $fecha): array;

    public function obtieneTodosLosEventosDeHoy(): array
    {
        return $this->obtieneTodosLosEventosPorFecha(date('d-m-Y'));
    }

    public abstract function obtieneTodosLosEventosPorFecha(string $fecha): array;
}