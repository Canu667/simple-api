<?php

namespace Tests\ExchangeRates;

use Entity\ExchangeEnquiry;
use ExchangeRates\Calculator;
use ExchangeRates\CalculatorInterface;
use ExchangeRates\ExchangeService;
use ExchangeRates\Provider\ProviderInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class ExchangeServiceTest extends TestCase
{
    /**
     * @var ProviderInterface|ObjectProphecy
     */
    protected $providerProphecy;

    /**
     * @var Calculator
     */
    protected $calculatorProphecy;

    /**
     * @var ExchangeService
     */
    protected $sut;

    public function setUp()
    {
        $this->providerProphecy = $this->prophesize()->willImplement(ProviderInterface::class);
        $this->calculatorProphecy = $this->prophesize()->willImplement(CalculatorInterface::class);

        $this->sut = new ExchangeService($this->providerProphecy->reveal(), $this->calculatorProphecy->reveal());
    }

    /**
     * @param string $baseCurrency
     * @param string $targetCurrency
     * @param float  $exchangeRate
     *
     * @dataProvider getExchangeRateProvider
     */
    public function testGetExchangeRate(string $baseCurrency, string $targetCurrency, float $exchangeRate)
    {
        $this->providerProphecy->getLatestExchangeRate($baseCurrency, $targetCurrency)->willReturn($exchangeRate);

        $this->assertSame($exchangeRate, $this->sut->getExchangeRate($baseCurrency, $targetCurrency));

        $this->providerProphecy
            ->getLatestExchangeRate($baseCurrency, $targetCurrency)
            ->shouldHaveBeenCalledTimes(1);
    }

    /**
     * @return array
     */
    public function getExchangeRateProvider(): array
    {
        return [
            [
                'baseCurrency'   => 'EUR',
                'targetCurrency' => 'PLN',
                'exchangeRate'   => 4.2,
            ],
            [
                'baseCurrency'   => 'USD',
                'targetCurrency' => 'CAD',
                'exchangeRate'   => 1.24,
            ],
        ];
    }

    /**
     * @param ExchangeEnquiry $enquiry
     * @param float           $exchangeRate
     *
     * @dataProvider exchangeDataProvider
     */
    public function testExchange(ExchangeEnquiry $enquiry, float $exchangeRate)
    {
        $this->providerProphecy->getLatestExchangeRate(
            $enquiry->getBaseCurrency(),
            $enquiry->getTargetCurrency()
        )->willReturn($exchangeRate);

        $expectedAmount = $enquiry->getAmount() * $exchangeRate;
        $this->calculatorProphecy->exchange($enquiry->getAmount(), $exchangeRate)->willReturn($expectedAmount);

        $exchangedAmount = $this->sut->exchange($enquiry);
        $this->assertSame($expectedAmount, $exchangedAmount);
    }

    /**
     * @return array
     */
    public function exchangeDataProvider(): array
    {
        return [
            [
                'enquiry'      => new ExchangeEnquiry(
                    1000.00,
                    'EUR',
                    'PLN'
                ),
                'exchangeRate' => 4.2,
            ],
            [
                'enquiry'      => new ExchangeEnquiry(
                    9999.00,
                    'CAD',
                    'USD'
                ),
                'exchangeRate' => 0.81,
            ],
            [
                'enquiry'      => new ExchangeEnquiry(
                    null,
                    null,
                    null
                ),
                'exchangeRate' => 4.2,
            ],
        ];
    }
}
