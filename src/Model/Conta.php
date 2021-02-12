<?php

namespace Banco\Model;

use Banco\Interface\Transferencia;

abstract class Conta implements Transferencia
{
    private string $agencia;
    private string $conta;

    public function __construct(string $agencia, string $conta)
    {
        if (strlen($agencia) != 4 || strlen($conta) != 6) {
            throw new \DomainException('Dados fornecidos inválidos');
        }

        $this->agencia = $agencia;
        $this->conta = $conta;
    }

    abstract public function depositar(float $valorDoDeposito): void;
    abstract public function sacar(float $valorDoSaque): string;

}