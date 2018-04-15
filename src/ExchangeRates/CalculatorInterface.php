<?php

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
