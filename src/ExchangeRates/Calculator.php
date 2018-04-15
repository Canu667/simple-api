<?php

namespace ExchangeRates;

class Calculator implements CalculatorInterface
{
    /**
     * @param float $baseAmount
     * @param float $exchangeRate
     *
     * @return float
     */
    public function exchange(float $baseAmount, float $exchangeRate): float
    {
        return $baseAmount * $exchangeRate;
    }
}
