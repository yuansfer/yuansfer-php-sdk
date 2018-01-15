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
$api = $yuansfer->createSecurePayRefund();

// set api parameters
$api
    ->setAmount(9.9) // The amount you need to refund.
    ->setReference('44444') // The unque ID of client’s system.
    ->setStoreManager('account', 'password'); // When the merchant is set need storeManager validate

try {
    // send to api get response
    // SecurePayRefund api return JSON
    // JSON already decode to PHP array
    $array = $api->send();

    // response array struct:
    // array(
    //    'ret_code' => '000100',
    //    'result' => array(
    //        'status' => 'success',
    //        'reference' => '44444',
    //        'refundTransactionId' => '297245675773380538',
    //        'oldTransactionId' => '297245675773319174',
    //    )
    // )
    var_dump($array);
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
