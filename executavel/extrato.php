<?php

use Banco\Model\ContaCorrente;
use Banco\Model\ContaPoupanca;

require_once '../vendor/autoload.php';

$joao = new ContaCorrente('1234', '123456');
$maria = new ContaPoupanca('4321', '654321');

$maria->depositar(1000);
$maria->depositar(1000);
$maria->sacar(1000);
$maria->sacar(100);
$maria->sacar(70);
$maria->transferir(200, $joao, 'ted');

$maria->extrato() . "\n\n";
echo $maria->saldo() . "\n\n";