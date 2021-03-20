<?php

namespace Banco\Service;

use Banco\Model\Conta;

class Pix implements Transferencia
{

    public function transferencia(float $valorDaTransferencia, Conta $contaDestino): float
    {
        $contaDestino->depositar($valorDaTransferencia);

        return $valorDaTransferencia + 0;
    }
}