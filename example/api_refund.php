<?php
/**
 * @see https://docs.yuansfer.com/#refund
 */
require dirname(__DIR__) . '/vendor/autoload.php';

use Yuansfer\Yuansfer;
use Yuansfer\Exception\YuansferException;

//init
$config = include __DIR__ . '/yuansfer_config.php';
$yuansfer = new Yuansfer($config);

// recommend: pass the test first
$yuansfer->setTestMode();

// create api
$api = $yuansfer->createRefund();

// set api parameters
$api
    ->setRefundAmount(0.01) // The amount you need to refund.
    ->setReference('444444'); // The unque ID of client’s system.

try {
    // send to api get response
    // SecurePayRefund api return JSON
    // JSON already decoded as PHP array
    $array = $api->send();

    var_dump($array);
} catch (YuansferException $e) {
    // required param is empty
    if ($e instanceof \Yuansfer\Exception\RequiredEmptyException) {
        $message = 'The param: ' . $e->getParam() . ' is empty, in API: ' . $e->getApi();
    }

    // http connect error
    if ($e instanceof \Yuansfer\Exception\HttpClientException) {
        $message = $e->getMessage();
    }

    // http response status code < 200 or >= 300
    if ($e instanceof \Yuansfer\Exception\HttpErrorException) {
        /** @var \Httpful\Response http response */
        $response = $e->getResponse();
    }
}
