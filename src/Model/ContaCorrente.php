<?php

namespace Banco\Model;

use Banco\Interface\Transferencia;
use Banco\Service\CalculaTaxas;
use Banco\Service\Extrato;
use Banco\Service\SistemaDeTransferencia;
use InvalidArgumentException;

class ContaCorrente extends Conta implements Transferencia
{
    private float $saldo;
    private Extrato $extrato;
    private SistemaDeTransferencia $sistemaDeTransferencia;
    private CalculaTaxas $juros;

    public function __construct(int $agencia, int $conta)
    {
        parent::__construct($agencia, $conta);

        $this->saldo = 0;
        $this->juros = new CalculaTaxas;
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

    public function depositar(float $valorDoDeposito): void
    {
        if ($valorDoDeposito == 0) {
            throw new InvalidArgumentException('Operação não permitida');
        }

        $this->extrato->movimentacao($valorDoDeposito, 'Deposito');
        $this->calcularSaldoDeposito($valorDoDeposito);
    }

    public function sacar(float $valorDoSaque): string
    {
        if ($valorDoSaque <= 0 || $this->saldo <= 0) {
            throw new InvalidArgumentException('Operação não permitida');
        }

        $this->extrato->movimentacao($valorDoSaque * -1, 'Saque');
        $this->calcularSaldoSaque($valorDoSaque);

        return 'Saldo em conta: ' . $this->saldo;
    }

    public function saldo(): string
    {
        return 'Saldo: ' . $this->saldo;
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

            case 'pix':
                    $this->sistemaDeTransferencia->pix($valorDaTransferencia, $contaDestino);
                    $this->extrato->movimentacao($valorDaTransferencia, 'Transferência por Pix');
            break;

            default:
                $this->sistemaDeTransferencia->pix($valorDaTransferencia, $contaDestino);
        }
    }

    public function extrato(): void
    {
        $this->extrato->mostrarExtrato();
    }
}