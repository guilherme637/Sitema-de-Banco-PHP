<?php

namespace Banco\Service;

use Banco\Model\Conta;

class SistemaTransferencia
{
    public function solicitarTransferencia(
        float $valorTransferencia,
        Conta $contaDestino,
        Transferencia $tipoTransferencia,
        float $saldo,
        Extrato $extrato
    ) {
        $juros = $tipoTransferencia->transferencia($valorTransferencia, $contaDestino);

        $extrato->movimentacao($valorTransferencia, 'transferência');

        return $saldo - $juros;
    }
}