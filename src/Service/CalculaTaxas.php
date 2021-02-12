<?php

namespace Banco\Service;

class CalculaTaxas
{
    public function ted(float $valorTed): float
    {
        if (!$valorTed >= 10000) {
            return $valorTed * 0.0010;
        }

        return $valorTed * 0.003;
    }

    public function doc(float $valorDoc): float
    {
        if ($valorDoc >= 10000) {
            return $valorDoc * 0.0015;
        }

        return $valorDoc * 0.002;
    }
}