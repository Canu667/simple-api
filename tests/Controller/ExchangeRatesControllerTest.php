<?php

namespace Tests\Controller;

use Symfony\Component\HttpFoundation\Request;

class ExchangeRatesControllerTest extends PipeWebTest
{
    public function testBasicRequestSuccess()
    {
        $amount = 100;
        $baseCurrency = 'EUR';
        $targetCurrency = 'PLN';

        $response = $this->sendRequest(Request::create("/exchange/$amount/$baseCurrency/$targetCurrency", 'GET'));

        $content = $response->getContent();

        $this->assertContains('result', $content);
    }
}
