<?php

namespace Banco\Service;

class Extrato
{
    private array $extrato;

    public function movimentacao(float $movimentacao, string $tipo): void
    {
        $this->extrato[] = ['tipo' => $tipo, 'valor' => $movimentacao];
    }

    public function mostrarExtrato(): void
    {
        foreach ($this->extrato as $movimentacao) {
            echo $movimentacao['tipo'] . ' -> ' . 'R$' . $movimentacao['valor'] . PHP_EOL;
            echo '--------------------------------------------' . PHP_EOL;
        }
    }
}