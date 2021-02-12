<?php

use Banco\Model\ContaCorrente;
use Banco\Model\ContaPoupanca;

require_once  'vendor/autoload.php';

$joao = new ContaCorrente('1234', '123456');
$maria = new ContaPoupanca('4321', '543216');

$guilherme = new ContaCorrente('2233', '112233');
$julia = new ContaCorrente('3322', '332211');

$alex = new ContaCorrente('4567', '198765');
$suzi = new ContaCorrente('7890', '543210');

$joao->depositar(50000);
$joao->transferir(10000, $maria, 'ted');

$guilherme->depositar(15000);
$guilherme->transferir(2000, $julia, 'doc');

$alex->depositar(70000);
$guilherme->transferir(50000, $suzi, 'pix');

echo 'João: R$' . $joao->saldo() . PHP_EOL;
echo 'Maria: R$' . $maria->saldo() . PHP_EOL;
PHP_EOL;
echo 'Guilherme: R$' . $guilherme->saldo() . PHP_EOL;
echo 'Júlia: R$' . $julia->saldo() . PHP_EOL;
PHP_EOL;
echo 'Alex: R$' . $alex->saldo() . PHP_EOL;
echo 'Suzi: R$' . $suzi->saldo() . PHP_EOL;
