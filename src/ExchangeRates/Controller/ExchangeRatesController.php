<?php
declare(strict_types=1);

namespace ExchangeRates\Controller;

use Entity\ExchangeEnquiry;
use Pipe\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExchangeRatesController extends Controller
{
    public function indexAction(string $amount, string $baseCurrency, string $targetCurrency): JsonResponse
    {
        $exchangeEnquiry = new ExchangeEnquiry((float) $amount, $baseCurrency, $targetCurrency);

        return new JsonResponse([
            'result' => $this->container->get('exchangeRates.service')->exchange($exchangeEnquiry),
        ]);
    }
}
