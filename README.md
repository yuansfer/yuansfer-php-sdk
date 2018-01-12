# Yuansfer PHP SDK

[Yuansfer Online API](https://docs.yuansfer.com/)

PHP >= 5.3

## Installation

``composer require "yuansfer/yuansfer-php-sdk:dev-master"``

## Usage

Please see [examples](https://github.com/yuansfer/yuansfer-php-sdk/tree/master/example)

### 1. Init
```php
$config = array(
    Yuansfer::MERCHANT_NO => 'The merchant NO.',
    Yuansfer::STORE_NO => 'The store NO.',
    Yuansfer::API_TOKEN => 'Yuansfer API token',
    Yuansfer::TEST_API_TOKEN => 'Yuansfer API token for test mode',
);

$yuansfer = new Yuansfer($config);
```

### 2. Create API
```php
$api = $yuansfer->createSecurePay();
```

### 3. Set API Parameters
```php
$api
    ->setAmount(9.9) //The amount of the transaction.
    ->setCurrency('USD') // The currency, USD, CAD supported yet.
    ->setVendor('alipay') // The payment channel, alipay, wechatpay, unionpay are supported yet.
    ->setTerminal('ONLINE') // ONLINE, WAP
    ->setReference('44444') //The unque ID of client's system.
    ->setIpnUrl('./SecurePayCallbackIpn.php') // The asynchronous callback method.
    ->setCallbackUrl('./SecurePayCallback.php'); // The Synchronous callback method.
```

### 4.1. Send to API
```php
$response = $api->send();
```

### 4.2. Use Test Mode
```php
$yuansfer->setTestMode();
$response = $api->send();
```

### 5.1. SecurePay API return HTML
```php
$api = $yuansfer->createSecurePay();

...

echo $response;
```

### 5.2. Others API return JSON, already decoded to array  
```php
$api = $yuansfer->createSecurePayRefund();

...

var_dump(is_array($response)); // bool(true)

if ($response['ret_code'] === '000100') {
    echo 'success';
}
```

### 6. Exception when Send to API
```php
try {
    $response = $api->send();
} catch (\Yuansfer\Exception\YuansferException $e) {
    // http connect error
    if ($e instanceof \Yuansfer\Exception\HttpClientException) {
        $message = $e->getMessage();
    }

    // http response status code < 200 or >= 300
    if ($e instanceof \Yuansfer\Exception\HttpErrorException) {
        /** @var \Httpful\Response http response */
        $response = $e->getResponse();
    }

    // required param is empty
    if ($e instanceof \Yuansfer\Exception\RequiredEmptyException) {
        $message = 'The param: ' . $e->getParam() . ' is empty, in API: ' . $e->getApi();
    }
}
```
