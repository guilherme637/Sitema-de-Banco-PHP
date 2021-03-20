<?php

namespace Banco\Model;

use Banco\Service\Extrato;
use Banco\Service\SistemaTransferencia;
use Banco\Service\Transferencia;
use InvalidArgumentException;

class ContaCorrente extends Conta
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
        $this->extrato = $extrato;
        $this->sistemaTransferencia = $sistemaTransferencia;
    }

    public function depositar(float $valorDoDeposito): void
    {
        if ($valorDoDeposito === 0) {
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

        $this->saldo -= $valorDoSaque;

        return 'Saldo em conta: ' . $this->saldo;
    }

    public function saldo(): string
    {
        return 'Saldo: ' . $this->saldo;
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