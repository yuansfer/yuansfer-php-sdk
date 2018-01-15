<?php
require dirname(__DIR__) . '/vendor/autoload.php';

use Yuansfer\Yuansfer;
use Yuansfer\Exception\YuansferException;

//init
$config = include __DIR__ . '/yuansfer_config.php';
$yuansfer = new Yuansfer($config);

// recommend: pass the test first
$yuansfer->setTestMode();

// create api
$api = $yuansfer->createSecurePay();

// set api parameters
$api
    ->setAmount(9.9) //The amount of the transaction.
    ->setCurrency('USD') // The currency, USD, CAD supported yet.
    ->setVendor('alipay') // The payment channel, alipay, wechatpay, unionpay are supported yet.
    ->setTerminal('ONLINE') // ONLINE, WAP
    ->setReference('44444') //The unque ID of client’s system.
    ->setIpnUrl('http://domain/example/callback_secure_pay_ipn.php') // The asynchronous callback method.
    ->setCallbackUrl('http://domain/example/callback_secure_pay.php'); // The Synchronous callback method.

try {
    // send to api get response
    // SecurePay api return html
    echo $api->send();
} catch (YuansferException $e) {
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
