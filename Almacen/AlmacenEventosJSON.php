<?php

class AlmacenEventosJSON extends AlmacenEventos
{
    const ARCHIVO_DE_EVENTOS = __DIR__ . '/eventos.json';

    public function __construct()
    {
        if (!file_exists(self::ARCHIVO_DE_EVENTOS)) {
            echo "ERROR: No se encuentra el archivo de eventos";
        }

        $eventosAlmacenados = json_decode(file_get_contents(self::ARCHIVO_DE_EVENTOS), true);
        foreach ($eventosAlmacenados as $evento => $valores) {
            if ($valores['activado']) {
                $this->eventosDisponibles[] = $evento;
                $this->suscriptores[$evento] = $valores['suscriptores'];
            }

            $this->eventos[] = $evento;
        }
    }
}