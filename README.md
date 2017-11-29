# gateio-guzzle

For license information check the [LICENSE](LICENSE)-file.

[![Latest Stable Version](https://poser.pugx.org/xutl/gateio/v/stable.png)](https://packagist.org/packages/xutl/gateio)
[![Total Downloads](https://poser.pugx.org/xutl/gateio/downloads.png)](https://packagist.org/packages/xutl/gateio)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist xutl/gateio
```

or add

```
"xutl/gateio": "~1.0"
```

to the require section of your composer.json.

使用
------------
````
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use xutl\gateio\Gateio;

$stack = HandlerStack::create();

//跟guzzlephp普通用法唯一的区别就是这里吧中间件加载进来，他会自动帮你签名重新包装请求参数。
$middleware = new Gateio([
    'accessKey' => '123456',
    'accessSecret' => '654321',
]);
$stack->push($middleware);

//这里设置 网关地址，数组参数请参见 https://gate.io/api2 
$client = new Client([
    'base_uri' => 'https://api.gate.io/api2/1',
    'handler' => $stack,
]);

$res = $client->get('private/cancelOrders', [
    'query' => [
        'aaa' => 'bbb',
    ]
]);

$res = $client->post('private/cancelOrders', [
    'form_params' => [
        'orders_json' => 'adafasdf'
     ]
]);

print_r($res->getBody()->getContents());
````

