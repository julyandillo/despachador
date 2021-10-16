<?php

interface Notificable
{
    public function notifica(string $evento, array $parametros);
}