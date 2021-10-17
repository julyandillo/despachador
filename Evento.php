<?php

class Evento
{
    const SEPARADOR = '.';

    private string $tipo;

    private string $nombre;

    private string $lanzador;

    private int $linea;

    private string $timestamp;

    private array $parametros;

    public function __construct(string $evento)
    {
        list($this->tipo, $this->nombre) = explode(self::SEPARADOR, $evento);
        $this->parametros = [];
        $this->lanzador = '';
        $this->linea = 0;
        $this->timestamp = date('d-m-Y H:i:s');
    }

    public function __toString(): string
    {
        return $this->tipo . self::SEPARADOR . $this->nombre;
    }

    public static function esValido(string $evento): bool
    {
        return strpos($evento, self::SEPARADOR) !== false;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function setTipo($tipo): self
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getLanzador(): string
    {
        return $this->lanzador;
    }

    public function setLanzador(string $lanzador): self
    {
        $this->lanzador = $lanzador;
        return $this;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function getParametros(): array
    {
        return $this->parametros;
    }

    public function setParametros(array $parametros): self
    {
        $this->parametros = $parametros;
        return $this;
    }

    public function getParametro(string $key)
    {
        if (!array_key_exists($key, $this->parametros)) {
            return null;
        }

        return $this->parametros[$key];
    }

    public function getLinea(): int
    {
        return $this->linea;
    }

    public function setLinea(int $linea): self
    {
        $this->linea = $linea;
        return $this;
    }

}