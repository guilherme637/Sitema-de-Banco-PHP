<?php

namespace Banco\Service;

use Banco\Interface\Transferencia;
use Banco\Model\Conta;

class Doc implements Transferencia
{

    public function transferencia(float $valorDaTransferencia, Conta $contaDestino): float
    {
        if ($valorDaTransferencia >= 10000) {
            $contaDestino->depositar($valorDaTransferencia);

            return $valorDaTransferencia * 0.0015;
        }

        return $valorDaTransferencia * 0.002;
    }
}