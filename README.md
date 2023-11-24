# curl_spear

## 介绍&历史

curl工具类库，于2021年3月11日正式建立，同日即发布0.0.1版本。
2023年11月23日，进行第一次重构。次日完成重构，并发布1.0.0正式版本。

## 教程

### Quick Start

```php
$client = \cmq2080\curl_spear\Client::instance();

$requestUrl = 'http://www.cmq2080.top/';
$queryParams = ['r' => 'timestamp'];

$client->get($requestUrl, $queryParams);
$resp = $client->getResponse();

print_r($resp->getCode());

if ($resp->isSuccess()) {
    print_r($resp->getContent());
}

```