# Yuansfer PHP SDK

[![Latest Stable Version](https://poser.pugx.org/yuansfer/yuansfer-php-sdk/v/stable)](https://packagist.org/packages/yuansfer/yuansfer-php-sdk)
[![Total Downloads](https://poser.pugx.org/yuansfer/yuansfer-php-sdk/downloads)](https://packagist.org/packages/yuansfer/yuansfer-php-sdk)
[![Monthly Downloads](https://poser.pugx.org/yuansfer/yuansfer-php-sdk/d/monthly)](https://packagist.org/packages/yuansfer/yuansfer-php-sdk)
[![License](https://poser.pugx.org/yuansfer/yuansfer-php-sdk/license)](https://packagist.org/packages/yuansfer/yuansfer-php-sdk)

[Yuansfer Online API](https://docs.pockyt.io/)


## Requirements

- PHP >= 5.3
- CURL extension


## Installation

1. Install composer:
   
    ```sh
    $ curl -sS https://getcomposer.org/installer | php
    ```
    
    More info about installation on [Linux / Unix / OSX](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
    and [Windows](https://getcomposer.org/doc/00-intro.md#installation-windows).
    
2. Run the Composer command to install the latest version of SDK:

    ```sh
    $ php composer.phar require yuansfer/yuansfer-php-sdk
    ```

3. Require Composer's autoloader in your PHP script (assuming it is in the same directory where you installed Composer):
   
      ```php
      require('vendor/autoload.php');
      ```

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
    Yuansfer::MER_GROUP_NO => 'The merchant group NO, optional.',
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
    ->setSettleCurrency('USD') // When the currency is "GBP", the settlement currency is "GBP". All other currencies settle with "USD"
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

[Official Documents](https://docs.pockyt.io/)

### IN-STORE API'S

#### Merchant Presented Workflow

| API                                                          | Call                             | Description                                                  |
| ------------------------------------------------------------ | -------------------------------- | ------------------------------------------------------------ |
| [Create QRC API](https://docs.pockyt.io/in-store-apis/merchant-presented-workflow/create-qrc-api) | `$yuansfer->createTransQrcode()` | This API generates a QR Code and transaction number for the customer to scan via their digital wallet app, allowing them to initiate the payment process. |

#### Customer Presented Workflow

| API                                                          | Call                     | Description                                                  |
| ------------------------------------------------------------ | ------------------------ | ------------------------------------------------------------ |
| [Add Transaction API](https://docs.pockyt.io/in-store-apis/customer-presented-workflow/add-transaction-api) | `$yuansfer->createAdd()` | This API enables the creation of a transaction object and allows the customer to retrieve a transaction number for initiating payment. |
| [Pay Transaction API](https://docs.pockyt.io/in-store-apis/customer-presented-workflow/pay-transaction-api) | `$yuansfer->createPrepay()`  | This will allow customers to make the final confirmation before submitting payment which will process through the digital wallet servers. |
| [Cancel API](https://docs.pockyt.io/in-store-apis/cancel-api) | `$yuansfer->createCancel()` | This API allows for canceling a payment transaction in either use case when the transaction is abandoned before submission, ensuring that merchants can efficiently manage their transactions. |

### REFUND AND QUERY API'S

| API                                                                   | Call                        | Description                                                                                                                                   |
|-----------------------------------------------------------------------| --------------------------- |-----------------------------------------------------------------------------------------------------------------------------------------------|
| [Refund API](https://docs.pockyt.io/refund-and-query-apis/refund-api) | `$yuansfer->createRefund()` | In the instance where a customer requests a refund, the following request and response objects are initiated to complete the refund workflow. |
| [Query API](https://docs.pockyt.io/refund-and-query-apis/query-api)   | `$yuansfer->createTranQuery()`      | This API is used for polling transaction results, researching transactions for refunds, and generating custom reports.                        |

### ECOMMERCE API'S

#### Pockyt Hosted Checkout

| API                                                          | Call                           | Description                       |
| ------------------------------------------------------------ | ------------------------------ | --------------------------------- |
| [SecurePay API](https://docs.pockyt.io/ecommerce-apis/pockyt-hosted-checkout/securepay-api) | `$yuansfer->createSecurePay()` | By using this API, the merchant website can send customers to Pockyt to receive payments. |

#### Pockyt Integrated Payments

| API                                                          | Call                         | Description                                                                                                                                                                                          |
| ------------------------------------------------------------ | ---------------------------- |------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| [Process API](https://docs.pockyt.io/pockyt-integrated-payments/process-api) | `$yuansfer->createProcess()` | Utilize our Partner Payment Gateways to accept popular wallets such as PayPal, Venmo, Google Pay, and Apple Pay. When integrating with Partner Payment Gateways, utilize both the 'process' endpoint |


#### Customer Records

| API                                                          | Call                         | Description                                                                                                                                                                                          |
| ------------------------------------------------------------ | ---------------------------- |------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| [Register Customer](https://docs.pockyt.io/customer-records/register-customer) | `$yuansfer->createCustomerCreate()` | Use this API to create a new customer, and receiving the Customer Number from Pockyt, to be invoked during calls to the SecurePay API. |
| [Retrieve Customer](https://docs.pockyt.io/customer-records/retrieve-customer) | `$yuansfer->createCustomerRetrieve()` | Use this API to retrieve the customer information stored in the record, to be used in calls to the SecurePay API. |
| [Update Customer](https://docs.pockyt.io/customer-records/update-customer) | `$yuansfer->createCustomerUpdate()` | Use this API to update information related to the customer's record. |

#### PAYOUTS API'S

#### Payouts

| API                                                          | Call                         | Description                                                                                                                                                                                          |
| ------------------------------------------------------------ | ---------------------------- |------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| [Register Payee](https://docs.pockyt.io/payouts-apis/payouts/register-payee) | `$yuansfer->createPayeeRegister()` | To initiate payments to your payees, you must first register an account with Pockyt. Send a POST request to the Register Customer endpoint, and you'll receive a customerNo in response. |
| [Retrieve Payee](https://docs.pockyt.io/payouts-apis/payouts/retrieve-payee) | `$yuansfer->createPayeeRetrieve()` | Acquire detailed information about a payee's account by sending a POST request to Pockyt's Retrieve Payee Account API. This enables you to manage and verify payee accounts effectively, maintaining the |
| [Update Payee](https://docs.pockyt.io/payouts-apis/payouts/update-payee) | `$yuansfer->createPayeeUpdate()` | To update payee details such as name, address, email, and bank info by providing customer No and new details. The API returns a confirmation message upon successful execution |
| [Add Payee Bank](https://docs.pockyt.io/payouts-apis/payouts/add-payee-bank) | `$yuansfer->createPayeeAddBank()` | Add a new payment method for the payee, such as a bank account. This endpoint requires the user to provide the Merhcnat ID and the payment details in the request payload. |
| [Transfer Payout](https://docs.pockyt.io/payouts-apis/payouts/transfer-payout) | `$yuansfer->createPayoutPay()` | To execute a payment, send a POST request to the payments endpoint. Upon successful validation, the specified amount will be transferred to the receiver, completing the payment transaction. |

## YIP

[Official Documents](https://bitbucket.org/pockyt-external/yip/src/master/)

### [capture](https://bitbucket.org/pockyt-external/yip/src/master/capture.md)

| API                                                          | Call                         | Description                                                                                                                                                                                              |
| ------------------------------------------------------------ | ---------------------------- |----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| /order/v4/capture | `$yuansfer->createYipOrderCapture()` | To fund a payment with a credit or debit card.                                                                                                                                                           |

### [no_vaulting](https://bitbucket.org/pockyt-external/yip/src/master/no_vaulting.md)

| API                                                | Call                         | Description                                                                                  |
| -------------------------------------------------- | ---------------------------- |----------------------------------------------------------------------------------------------|
| /online/v4/secure-pay | `$yuansfer->createYipSecurePay()` |                                                                                              |
| PayPal Payment Method | `$yuansfer->createYipOrderProcess()` | Call this API when the customer approved the payment order, see HTML Sample code at #line 57 |
| Card Payment Method | `$yuansfer->createYipOrderProcess()` | Call this API when the customer approved the payment order, see HTML Sample code at #line 57 |

### [with_vaulting](https://bitbucket.org/pockyt-external/yip/src/master/with_vaulting.md)

| API                                                | Call                                        | Description                                                                                  |
| -------------------------------------------------- |---------------------------------------------|----------------------------------------------------------------------------------------------|
| Capture order and save payment methods | `$yuansfer->createYipSecurePayVault()`      |                                                                                              |
| Complete the payment transaction | `$yuansfer->createYipOrderProcess()`        | Call this API when the customer approved the payment order, see HTML Sample code at #line 57 |
| Pay with saved payment methods | `$yuansfer->createYipSecurePayVaultSaved()` |                                                                                              |
