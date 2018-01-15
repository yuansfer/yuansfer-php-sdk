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
$config = include __DIR__ . '/yuansfer_config.php';
$yuansfer = new Yuansfer($config);

if (!$yuansfer->verifyIPN()) {
    // verifySign not verified
    header('HTTP/1.1 503 Service Unavailable', true, 503);

    exit;
}

//find order use $_POST['reference']
$order = Order::find($_POST['reference']);

if ($_POST['status'] === 'success') {
    // process of order success
    $order->success();

    // must output: "success", otherwise yuansfer will be considered a failure
    echo 'success';
} else {
    // process of order failed
    $order->failed();
}




