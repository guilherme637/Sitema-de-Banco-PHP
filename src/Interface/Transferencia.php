<?php

namespace Banco\Interface;

use Banco\Model\Conta;

interface Transferencia
{
    public function transferencia(float $valorDaTransferencia, Conta $contaDestino): float;
}