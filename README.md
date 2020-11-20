# Yuansfer PHP SDK

[![Latest Stable Version](https://poser.pugx.org/yuansfer/yuansfer-php-sdk/v/stable)](https://packagist.org/packages/yuansfer/yuansfer-php-sdk)
[![Total Downloads](https://poser.pugx.org/yuansfer/yuansfer-php-sdk/downloads)](https://packagist.org/packages/yuansfer/yuansfer-php-sdk)
[![Monthly Downloads](https://poser.pugx.org/yuansfer/yuansfer-php-sdk/d/monthly)](https://packagist.org/packages/yuansfer/yuansfer-php-sdk)
[![License](https://poser.pugx.org/yuansfer/yuansfer-php-sdk/license)](https://packagist.org/packages/yuansfer/yuansfer-php-sdk)

[Yuansfer Online API](https://docs.yuansfer.com/)


## Requirements

- PHP >= 5.3
- CURL extension


## Installation

### With Composer (recommended)

1. Install composer:
   
    ```sh
    $ curl -sS https://getcomposer.org/installer | php
    ```
    
    More info about installation on [Linux / Unix / OSX](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
    and [Windows](https://getcomposer.org/doc/00-intro.md#installation-windows).
    
2. Run the Composer command to install the latest version of SDK:

    ```sh
    php composer.phar require yuansfer/yuansfer-php-sdk
    ```

3. Require Composer's autoloader in your PHP script (assuming it is in the same directory where you installed Composer):
   
      ```php
      require('vendor/autoload.php');
      ```
### PHAR with bundled dependencies

**This is not recommended! Use [Composer](http://getcomposer.org) as modern way of working with PHP packages.**

1. Download [PHAR file](https://github.com/yuansfer/yuansfer-php-sdk/releases/latest)

2. Require files:
  
    ```php
    require('path-to-sdk/yuansfer-php-sdk.phar');
    ```

Please keep in mind that bundled dependencies may interfere with your other dependencies.

## Usage

Please see [examples](https://github.com/yuansfer/yuansfer-php-sdk/tree/master/example)

### 1. Init
```php
use Yuansfer\Yuansfer;

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
    ->setVendor('alipay') // The payment channel, alipay, wechatpay, unionpay, enterprisepay are supported yet.
    ->setReference('44444') //The unque ID of client's system.
    ->setIpnUrl('http://domain/example/callback_secure_pay_ipn.php') // The asynchronous callback method.
    ->setCallbackUrl('http://domain/example/callback_secure_pay.php'); // The Synchronous callback method.
```

### 4.1. Send
```php
$response = $api->send();
```

### 4.2. Use Test Mode
```php
$yuansfer->setTestMode();
$response = $api->send();
```

### 5. API return JSON, already decoded as array  
```php
if ($response['ret_code'] === '000100') {
	header('Location: ' . $response['result']['cashierUrl']);
}
```

### 6. Exceptions when sending
```php
try {
    $response = $api->send();
} catch (\Yuansfer\Exception\YuansferException $e) {
    // required param is empty
    if ($e instanceof \Yuansfer\Exception\RequiredEmptyException) {
        $message = 'The param: ' . $e->getParam() . ' is empty, in API: ' . $e->getApi();
    }

    // http connect error
    if ($e instanceof \Yuansfer\Exception\HttpClientException) {
        $message = $e->getMessage();
    }

    // http response status code < 200 or >= 300, 301 and 302 will auto redirect
    if ($e instanceof \Yuansfer\Exception\HttpErrorException) {
        /** @var \Httpful\Response http response */
        $response = $e->getResponse();
    }
}
```



## API Documents

[Official Documents](https://docs.yuansfer.com/)

### Payments

#### Online Payment

##### Yuansfer Checkout

| API                                                          | Call                           | Description                       |
| ------------------------------------------------------------ | ------------------------------ | --------------------------------- |
| [secure-pay()](https://docs.yuansfer.com/api-reference-v3/payments/online-payment/secure-pay) | `$yuansfer->createSecurePay()` | This is used to pay for an order. |

##### Yuansfer Integrated Payment

| API                                                          | Call                        | Description                                          |
| ------------------------------------------------------------ | --------------------------- | ---------------------------------------------------- |
| [prepay()](https://docs.yuansfer.com/api-reference-v3/payments/online-payment/prepay) | `$yuansfer->createPrepay()` | This API does the mobile payment for the POS system. |

#### Point of Sale Payment

##### Scan QR Code

| API                                                          | Call                     | Description                                                  |
| ------------------------------------------------------------ | ------------------------ | ------------------------------------------------------------ |
| [add()](https://docs.yuansfer.com/api-reference-v3/payments/in-store-payment/scan-qrcode/add) | `$yuansfer->createAdd()` | This API initiates a **Barcode/QR Code Payment** request and creates a transaction order. |
| [pay()](https://docs.yuansfer.com/api-reference-v3/payments/in-store-payment/scan-qrcode/pay) | `$yuansfer->createPay()` | This API places an order in the **Barcode/QR Code Payment**. |

#### Create QR Code

| API                                                          | Call                             | Description                                                  |
| ------------------------------------------------------------ | -------------------------------- | ------------------------------------------------------------ |
| [create-trans-qrcode()](https://docs.yuansfer.com/api-reference-v3/payments/in-store-payment/create-qrcode) | `$yuansfer->createTransQrcode()` | This API creates a transaction and get a QR code for customers to scan to pay in the **Transaction QR Code Payment** process. Customers scan this QR code using the wallet app to checkout. |

### Transaction Revert

| API                                                          | Call                        | Description                                    |
| ------------------------------------------------------------ | --------------------------- | ---------------------------------------------- |
| [refund()](https://docs.yuansfer.com/#refund)                | `$yuansfer->createRefund()` | This API refunds the payment of a transaction. |
| [cancel()](https://docs.yuansfer.com/api-reference-v3/transaction-revert/cancel) | `$yuansfer->createCancel()` | This API cancels the payment of a transaction. |



### Transaction Data Search

| API                                                          | Call                                | Description                                                  |
| ------------------------------------------------------------ | ----------------------------------- | ------------------------------------------------------------ |
| [tran-query()](https://docs.yuansfer.com/api-reference-v3/transaction-data-search/tran-query) | `$yuansfer->createTranQuery()`      | This API gets the transaction details by ID of a transaction in the merchant's system. |
| [trans-list()](https://docs.yuansfer.com/api-reference-v3/transaction-data-search/trans-list) | `$yuansfer->createTransList()`      | This API gets all transaction details for a given time period. |
| [settle-list()](https://docs.yuansfer.com/api-reference-v3/transaction-data-search/settle-list) | `$yuansfer->createSettleList()`     | This API gets all settlement details for a given time period. |
| [withdrawal-list()](https://docs.yuansfer.com/api-reference-v3/transaction-data-search/withdrawal-list) | `$yuansfer->createWithdrawalList()` | This API gets all withdrawal details for a given time period. |
| [data-status()](https://docs.yuansfer.com/api-reference-v3/transaction-data-search/data-status) | `$yuansfer->createDataStatus()`     | This API gets the settlement status for a given date.        |
