<?php

namespace ExchangeRates\Provider;

interface ProviderInterface
{
    /**
     * @param string $baseCurrency
     * @param string $targetCurrency
     *
     * @return float
     */
    public function getLatestExchangeRate(string $baseCurrency, string $targetCurrency): float;
}
