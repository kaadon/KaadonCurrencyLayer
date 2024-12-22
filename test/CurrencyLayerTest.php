<?php

namespace Kaadon\Test;

use Kaadon\CurrencyLayer\driver\CurrencyLayer;
use Kaadon\CurrencyLayer\RealTimeRates;
use PHPUnit\Framework\TestCase;

class CurrencyLayerTest extends TestCase
{
    /**
     * @throws \Kaadon\CurrencyLayer\CurrencyLayerException
     */
    public function testGet()
    {
        $accessKey = 'c95f0bacbe3fa8436c018ac977fdfe8d';
        $currencyLayer = new RealTimeRates($accessKey,"USD");
        $response = $currencyLayer->getRates('CNY,EUR,DZD,LKR,GBP,AUD,AWG,AZN');
        var_dump($response);
        $this->assertIsArray($response);
    }
}