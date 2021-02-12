<?php

namespace Banco\Model;

use Banco\Interface\Transferencia;
use Banco\Service\Extrato;
use Banco\Service\SistemaDeTransferencia;
use DomainException;
use InvalidArgumentException;

class ContaPoupanca extends Conta implements Transferencia
{
    private float $saldo;
    private Extrato $extrato;
    private SistemaDeTransferencia $sistemaDeTransferencia;

    public function __construct(string $agencia, string $conta)
    {
        parent::__construct($agencia, $conta);

        $this->saldo = 50;
        $this->sistemaDeTransferencia = new SistemaDeTransferencia;
        $this->extrato = new Extrato;
    }

    private function calcularSaldoSaque(float $valorDoCalculo): float
    {
        return $this->saldo -= $valorDoCalculo;
    }

    private function calcularSaldoDeposito(float $valorDoCalculo):float
    {
        return $this->saldo += $valorDoCalculo;
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
        $this->calcularSaldoDeposito($valorDoDeposito);
    }

    public function sacar(float $valorDoSaque): string
    {
        $saque = $this->calcularSaldoSaque($valorDoSaque);
        $this->extrato->movimentacao($valorDoSaque, 'Saque');

        if ($saque <= 0) {
            throw new DomainException('Valor não permitido para saque');
        }

        return 'Saldo em conta: ' . $this->saldo;
    }

    public function transferir(float $valorDaTransferencia, Transferencia $contaDestino, string $tipo = null): void
    {
        switch ($tipo) {
            case 'ted':
                $jurosTed = $this->sistemaDeTransferencia->ted($valorDaTransferencia, $contaDestino);
                $this->extrato->movimentacao($valorDaTransferencia, 'Transferência por TED');
                $this->calcularSaldoSaque($jurosTed);
                break;

            case 'doc':
                $jurosDoc = $this->sistemaDeTransferencia->doc($valorDaTransferencia, $contaDestino);
                $this->extrato->movimentacao($valorDaTransferencia, 'Transferência por DOC');
                $this->calcularSaldoSaque($jurosDoc);
                break;

            default:
                $jurosTed = $this->sistemaDeTransferencia->ted($valorDaTransferencia, $contaDestino);
                $this->extrato->movimentacao($valorDaTransferencia, 'Transferência por TED');
                $this->calcularSaldoSaque($jurosTed);
        }
    }

    public function extrato(): void
    {
        $this->extrato->mostrarExtrato();
    }
}