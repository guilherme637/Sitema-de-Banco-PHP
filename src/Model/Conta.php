<?php

namespace Banco\Model;

use Banco\Service\Transferencia;

abstract class Conta
{
    private string $agencia;
    private string $conta;
    protected float $saldo;

    public function __construct(string $agencia, string $conta)
    {
        if (strlen($agencia) != 4 || strlen($conta) != 6) {
            throw new \DomainException('Dados fornecidos inválidos');
        }

        $this->agencia = $agencia;
        $this->conta = $conta;
        $this->saldo = 0;
    }

    abstract public function depositar(float $valorDoDeposito): void;

    abstract public function sacar(float $valorDoSaque): string;

    abstract public function transferir(float $valorDaTransferencia, Conta $contaDestino, Transferencia $tipo): void;
}