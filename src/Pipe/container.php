<?php

use ExchangeRates\ExchangeService;
use ExchangeRates\Provider\Fixer;
use ExchangeRates\Calculator;
use GrahamCampbell\GuzzleFactory\GuzzleFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;

$dependencyContainer = new ContainerBuilder();

$dependencyContainer->setParameter('exchangeRates.fixerBaseUri', 'https://api.fixer.io/latest');

$client = GuzzleFactory::make();
$dependencyContainer->set('guzzle.client', $client);

$provider = new Fixer(
    $dependencyContainer->getParameter('exchangeRates.fixerBaseUri'),
    $dependencyContainer->get('guzzle.client')
);
$dependencyContainer->set('exchangeRates.provider.fixer', $provider);

$dependencyContainer->set('exchangeRates.calculator', new Calculator());

$exchangeService = new ExchangeService(
    $dependencyContainer->get('exchangeRates.provider.fixer'),
    $dependencyContainer->get('exchangeRates.calculator')
);

$dependencyContainer->set('exchangeRates.service', $exchangeService);

return $dependencyContainer;
