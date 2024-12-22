# <center> 币种汇率 </center>

## 1. 获取实时汇率
```php
use Kaadon\CurrencyLayer\RealTimeRates;
$accessKey = 'c95f0bacbe3fa8436c018ac977fdfe8d';
$currencyLayer = new RealTimeRates($accessKey,"USD");
$response = $currencyLayer->getRates('CNY,EUR,DZD,LKR,GBP,AUD,AWG,AZN');

```
