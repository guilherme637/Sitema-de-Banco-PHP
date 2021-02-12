<?php

namespace Banco\Service;

use Banco\Interface\Transferencia;

class SistemaDeTransferencia
{
    private CalculaTaxas $juros;

    public function __construct()
    {
        $this->juros = new CalculaTaxas;
    }


    public function ted(float $valorDaTransferencia, Transferencia $contaDestino): float
    {
        if ($valorDaTransferencia >= 20000) {
            throw new \InvalidArgumentException('Valor muito alto para transferência TED');
        }

        $contaDestino->depositar($valorDaTransferencia);

        return $this->juros->ted($valorDaTransferencia);
    }

    public function doc(float $valorDaTransferencia, Transferencia $contaDestino): float
    {
        if ($valorDaTransferencia >= 30000) {
            throw new \InvalidArgumentException('Valor muito alto para transferência DOC');
        }

        $contaDestino->depositar($valorDaTransferencia);

        return $this->juros->doc($valorDaTransferencia);
    }

    public function pix(float $valorDaTransferencia, Transferencia $contaDestino)
    {
        $contaDestino->depositar($valorDaTransferencia);
    }
}