<?php

include_once 'Evento.php';

interface Notificable
{
    public function notifica(Evento $evento);
}