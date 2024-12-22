<?php

namespace Kaadon\CurrencyLayer\driver;

class CurrencyLayer
{
    protected string $endpoint = '';
    protected array $data = [];
    public function __construct($access_key)
    {
        $this->data['access_key'] = $access_key;
    }
    public function get($endpoint,$params = []): ?object
    {
        $this->endpoint = $endpoint;
        $this->data = array_merge($this->data, $params);
        return $this->Send();
    }
    private function Send(): ?object
    {
        // 将data数组url字符串
        $url = http_build_query($this->data);
        $ch = curl_init('https://api.currencylayer.com/' . $this->endpoint . '?' . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        if ($json) {
            return (object)json_decode($json, true);
        } else {
            return null;
        }
    }

    protected function isSupport(string $currency): bool
    {
        if (CurrencyEnum::tryFrom($currency)) {
            return true;
        }
        return false;
    }
}