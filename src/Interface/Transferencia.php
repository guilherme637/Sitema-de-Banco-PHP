<?php

namespace Banco\Interface;

interface Transferencia
{
    public function transferir(float $valorDaTransferencia, Transferencia $contaDestino, string $tipo = null): void;
}