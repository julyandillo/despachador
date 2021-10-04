<?php

class AlmacenEventosJSON extends AlmacenEventos
{
    const ARCHIVO_DE_EVENTOS = __DIR__ . '/eventos.json';

    public function __construct()
    {
        if (!file_exists(self::ARCHIVO_DE_EVENTOS)) {
            echo "ERROR: No se encuentra el archivo de eventos";
        }

        $this->suscriptores = json_decode(file_get_contents(self::ARCHIVO_DE_EVENTOS), true);
        $this->eventos = array_keys($this->suscriptores);
    }
}