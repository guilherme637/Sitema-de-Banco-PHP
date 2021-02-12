<?php

namespace Banco\Model;

use Banco\Interface\Transferencia;
use Banco\Service\CalculaTaxas;
use Banco\Service\SistemaDeTransferencia;

class ContaCorrente extends Conta implements Transferencia
{
    private float $saldo;
    private SistemaDeTransferencia $sistemaDeTransferencia;
    private CalculaTaxas $juros;

    public function __construct(int $agencia, int $conta)
    {
        parent::__construct($agencia, $conta);

        $this->saldo = 0;
        $this->juros = new CalculaTaxas;
        $this->sistemaDeTransferencia = new SistemaDeTransferencia;
    }

    public function depositar(float $valorDoDeposito): void
    {
        if ($valorDoDeposito == 0) {
            throw new \InvalidArgumentException('Operação não permitida');
        }

        $this->saldo += $valorDoDeposito;
    }

    public function sacar(float $valorDoSaque): string
    {
        if ($valorDoSaque <= 0 || $this->saldo <= 0) {
            throw new \InvalidArgumentException('Operação não permitida');
        }

        $this->saldo -= $valorDoSaque;

        return 'Saldo em conta: ' . $this->saldo;
    }

    public function saldo(): float
    {
        return $this->saldo;
    }

    public function transferir(float $valorDaTransferencia, Transferencia $contaDestino, string $tipo): string
    {
        switch ($tipo) {
            case 'ted':
                $jurosTed = $this->sistemaDeTransferencia->ted($valorDaTransferencia, $contaDestino);
                $this->sacar($jurosTed);
            break;

            case 'doc':
                $jurosDoc = $this->sistemaDeTransferencia->doc($valorDaTransferencia, $contaDestino);
                $this->sacar($jurosDoc);
            break;

            case 'pix':
                    $this->sistemaDeTransferencia->pix($valorDaTransferencia, $contaDestino);
            break;
        }

        return 'Transferência realizada por '. $tipo;
    }
}