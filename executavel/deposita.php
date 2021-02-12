<?php

use Banco\Model\ContaCorrente;

require_once '../vendor/autoload.php';

$joão = new ContaCorrente('1234', '123456');
$maria = new ContaCorrente('4312', '654321');

$joão->depositar(1000);
$maria->depositar(200);

echo 'João: R$' . $joão->saldo() . PHP_EOL;
echo 'Maria: R$' . $maria->saldo();