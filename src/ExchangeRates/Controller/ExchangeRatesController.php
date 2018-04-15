<?php
declare(strict_types = 1);

namespace ExchangeRates\Controller;

use Entity\ExchangeEnquiry;
use ExchangeRates\Calculator;
use ExchangeRates\ExchangeService;
use ExchangeRates\Provider\Fixer;
use GrahamCampbell\GuzzleFactory\GuzzleFactory;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExchangeRatesController
{
    public function indexAction(string $amount, string $baseCurrency, string $targetCurrency): JsonResponse
    {
        $baseUri = 'https://api.fixer.io/latest';
        $client = GuzzleFactory::make();
        $provider = new Fixer($baseUri, $client);

        $exchangeService = new ExchangeService($provider, new Calculator());

        $exchangeEnquiry = new ExchangeEnquiry((float) $amount, $baseCurrency, $targetCurrency);

        return new JsonResponse(['result' => $exchangeService->exchange($exchangeEnquiry)]);
    }
}
