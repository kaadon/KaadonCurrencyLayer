<?php

namespace Kaadon\CurrencyLayer;

use Kaadon\CurrencyLayer\driver\CurrencyLayer;

class RealTimeRates extends CurrencyLayer
{
    protected string $endpoint = 'live';

    /**
     * @throws \Kaadon\CurrencyLayer\CurrencyLayerException
     */
    public function __construct($access_key, $source = 'USD')
    {
        parent::__construct($access_key);
        // 判断source是否支持
        if ($this->isSupport($source)) {
            $this->data['source'] = $source;
        } else {
            throw new CurrencyLayerException('The source currency is not supported');
        }
    }

    /**
     * @throws \Kaadon\CurrencyLayer\CurrencyLayerException
     */
    public function getRates($currencies = ''): ?array
    {
        $currenciesArr = line_array($currencies);
        $new_currenciesArr = array_filter($currenciesArr, function ($currency) {
            return $this->isSupport($currency) && $currency != $this->data['source'];
        });
        if (count($new_currenciesArr) == 0) {
            throw new CurrencyLayerException('The currency is not supported, please check the currency');
        }
        $this->data['currencies'] = implode(',', $new_currenciesArr);
        $response = parent::get($this->endpoint);
        if (is_array($response?->quotes) && count($response?->quotes) > 0) {
            $quotes = $response->quotes;
            array_map(function ($key) use (&$quotes) {
                //获取key的长度
                $length = strlen($this->data['source']);
                //获取key的3位后的字符串
                $currency = substr($key, $length);
                $rates = $quotes[$key];
                $quotes[$key] = [
                    'currency' => $currency,
                    'source' => $this->data['source'],
                    'rate' => $rates
                ];
            }, array_keys($response->quotes));
            return $quotes;
        } else {
            return null;
        }
    }
}