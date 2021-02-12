<?php

namespace Banco\Model;

use Banco\Interface\Transferencia;
use Banco\Service\SistemaDeTransferencia;

class ContaPoupanca extends Conta implements Transferencia
{
    private float $saldo;
    private SistemaDeTransferencia $sistemaDeTransferencia;

    public function __construct(string $agencia, string $conta)
    {
        parent::__construct($agencia, $conta);

        $this->saldo = 50;
        $this->sistemaDeTransferencia = new SistemaDeTransferencia;
    }

    public function saldo(): float
    {
        return $this->saldo;
    }

    public function depositar(float $valorDoDeposito): void
    {
        if ($valorDoDeposito < 25 || $valorDoDeposito <= 0) {
            throw new \InvalidArgumentException('Valor mínimo de deposito é de R$25');
        }

        $this->saldo += $valorDoDeposito;
    }

    public function sacar(float $valorDoSaque): string
    {
        $saque = $this->saldo -= $valorDoSaque;

        if ($saque <= 0) {
            throw new \DomainException('Valor não permitido para saque');
        }

        return 'Saque efetuado';
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

        }

        return 'Transferência realizada';
    }
}