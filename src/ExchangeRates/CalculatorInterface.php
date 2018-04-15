<?php

declare(strict_types = 1);

namespace ExchangeRates;

interface CalculatorInterface
{
    /**
     * @param float $baseAmount
     * @param float $exchangeRate
     *
     * @return float
     */
    public function exchange(float $baseAmount, float $exchangeRate): float;
}
