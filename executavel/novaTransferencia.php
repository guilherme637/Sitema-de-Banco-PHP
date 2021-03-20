<?php

use Banco\Model\ContaCorrente;
use Banco\Service\Doc;
use Banco\Service\Extrato;
use Banco\Service\Pix;
use Banco\Service\SistemaTransferencia;

require_once '../vendor/autoload.php';

$joao = new ContaCorrente('1234', '123456', new Extrato(), new SistemaTransferencia());
$maria = new ContaCorrente('4321', '654321', new Extrato(), new SistemaTransferencia());


$joao->depositar(5000);
$joao->transferir(1000, $maria, new Doc());

$joao->extrato() . PHP_EOL;
echo "\n";
echo $joao->saldo();
