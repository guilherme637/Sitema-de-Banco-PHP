<?php

use Banco\Model\ContaCorrente;
use Banco\Model\ContaPoupanca;
use Banco\Service\Pix;

require_once '../vendor/autoload.php';

$joao = new ContaCorrente('1234', '123456');
$maria = new ContaCorrente('4321', '654321');


$joao->depositar(5000);
$joao->transferir(1000, $maria, new Pix);

$joao->extrato() . PHP_EOL;
echo $joao->saldo();
