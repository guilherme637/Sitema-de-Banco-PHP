<?php

namespace Banco\Model;

use Banco\Service\Transferencia;
use Banco\Service\Extrato;
use Banco\Service\SistemaTransferencia;
use DomainException;
use InvalidArgumentException;

class ContaPoupanca extends Conta
{
    private Extrato $extrato;
    private SistemaTransferencia $sistemaTransferencia;

    public function __construct(
        string $agencia,
        string $conta,
        Extrato $extrato,
        SistemaTransferencia $sistemaTransferencia
    ) {
        parent::__construct($agencia, $conta);

        $this->saldo = 50;
        $this->extrato = $extrato;
        $this->sistemaTransferencia = $sistemaTransferencia;
    }

    public function saldo(): float
    {
        return $this->saldo;
    }

    public function depositar(float $valorDoDeposito): void
    {
        if ($valorDoDeposito < 25 || $valorDoDeposito <= 0) {
            throw new InvalidArgumentException('Valor mínimo de deposito é de R$25');
        }

        $this->extrato->movimentacao($valorDoDeposito, 'Deposito');
        $this->saldo += $valorDoDeposito;
    }

    public function sacar(float $valorDoSaque): string
    {
        $saque = $this->saldo -= $valorDoSaque;

        $this->extrato->movimentacao($valorDoSaque, 'Saque');

        if ($saque <= 0) {
            throw new DomainException('Valor não permitido para saque');
        }

        return 'Saldo em conta: ' . $this->saldo;
    }


    public function transferir(float $valorDaTransferencia, Conta $contaDestino, Transferencia $tipo): void
    {
        $transferido = $this->sistemaTransferencia->solicitarTransferencia(
            $valorDaTransferencia,
            $contaDestino,
            $tipo,
            $this->saldo,
            $this->extrato
        );
            
        $this->saldo = $transferido;
    }

    public function extrato(): void
    {
        $this->extrato->mostrarExtrato();
    }

}