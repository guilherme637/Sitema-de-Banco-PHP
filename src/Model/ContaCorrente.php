<?php

namespace Banco\Model;

use Banco\Interface\Transferencia;
use Banco\Service\Extrato;
use Banco\Service\SistemaDeTransferencia;
use InvalidArgumentException;

class ContaCorrente extends Conta
{
    private Extrato $extrato;
    private SistemaDeTransferencia $sistemaDeTransferencia;

    public function __construct(int $agencia, int $conta)
    {
        parent::__construct($agencia, $conta);

        $this->sistemaDeTransferencia = new SistemaDeTransferencia;
        $this->extrato = new Extrato;
    }

    public function depositar(float $valorDoDeposito): void
    {
        if ($valorDoDeposito == 0) {
            throw new InvalidArgumentException('Operação não permitida');
        }

        $this->extrato->movimentacao($valorDoDeposito, 'Deposito');
        $this->saldo += $valorDoDeposito;
    }

    public function sacar(float $valorDoSaque): string
    {
        if ($valorDoSaque <= 0 || $this->saldo <= 0) {
            throw new InvalidArgumentException('Operação não permitida');
        }

        $this->extrato->movimentacao($valorDoSaque * -1, 'Saque');
        $this->saldo -=  $valorDoSaque;

        return 'Saldo em conta: ' . $this->saldo;
    }

    public function saldo(): string
    {
        return 'Saldo: ' . $this->saldo;
    }

    public function transferir(float $valorDaTransferencia, Conta $contaDestino, Transferencia $tipo): void
    {
        $juros = $tipo->transferencia($valorDaTransferencia, $contaDestino);
        $this->extrato->movimentacao($valorDaTransferencia,'Transferencia');
        $this->saldo -= $juros;
    }

    public function extrato(): void
    {
        $this->extrato->mostrarExtrato();
    }
}