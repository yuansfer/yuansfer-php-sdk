<?php
require dirname(__DIR__) . '/vendor/autoload.php';

use Yuansfer\Yuansfer;
use Yuansfer\Exception\YuansferException;

//init
$config = array(
    Yuansfer::MERCHANT_NO => 'The merchant NO.',
    Yuansfer::STORE_NO => 'The store NO.',
    Yuansfer::API_TOKEN => 'Yuansfer API token',
    Yuansfer::TEST_API_TOKEN => 'Yuansfer API token for test mode',
);

$yuansfer = new Yuansfer($config);

// recommend: pass the test first
$yuansfer->setTestMode();

// create api
$api = $yuansfer->createSecurePayReferenceQuery();

// set api parameters
$api->setReference('100787002'); // The unque ID of client’s system.

try {
    // send to api get response
    // SecurePayReferenceQuery api return JSON
    // JSON already decode to PHP array
    $array = $api->send();

    // response array struct:
    // array(
    //    'ret_code' => '000100',
    //    'ret_msg' => 'query success ',
    //    'result' => array(
    //        'reference' => '100787002',
    //        'yuansferId' => '297553546536513047',
    //        'amount' => '0.01',
    //        'refundInfo' => array(
    //            array(
    //              'refundYuansferId' => '297553546536987987',
    //              'refundAmount' => '0.01',
    //            )
    //        ),
    //        'status' => 'success',
    //        'refundAmount' => '0.01',
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
