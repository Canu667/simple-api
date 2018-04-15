<?php
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();
$routes->add('exchangeRates', new Routing\Route('/exchange/{amount}/{baseCurrency}/{targetCurrency}', [
    'amount' => null,
    'baseCurrency' => null,
    'targetCurrency' => null,
    '_controller' => 'ExchangeRates\Controller\ExchangeRatesController::indexAction',
]));

return $routes;
