<?php
require dirname(__DIR__) . '/vendor/autoload.php';

use Yuansfer\Yuansfer;

// order sample
class Order {
    public static function find($ref)
    {
        //find order use reference
        $order = new Order($ref);

        return $order;
    }

    public function success()
    {

    }

    public function failed()
    {

    }
}

//init
$config = array(
    Yuansfer::MERCHANT_NO => 'The merchant NO.',
    Yuansfer::STORE_NO => 'The store NO.',
    Yuansfer::API_TOKEN => 'Yuansfer API token',
    Yuansfer::TEST_API_TOKEN => 'Yuansfer API token for test mode',
);

$yuansfer = new Yuansfer($config);

if (!$yuansfer->verifyIPN()) {
    // verifySign not verified
    header('HTTP/1.1 503 Service Unavailable', true, 503);

    exit;
}

//find order use $_POST['reference']
$order = Order::find($_POST['reference']);

if ($_POST['status'] === 'success') {
    // order success
    $order->success();

    echo 'success';
} else {
    // order failed
    $order->failed();
}




