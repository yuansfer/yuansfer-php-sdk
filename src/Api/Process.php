<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class Process
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/api-reference-v3/payments/online-payment/yuansfer-integrated-payment/braintree-payments
 *
 * @method $this setPaymentMethodNonce(string $paymentMethodNonce)
 * @method $this setTransactionNo(string $transactionNo)
 */
class Process extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'paymentMethodNonce',
            'paymentMethod',
            'transactionNo',
        ));

        $this->addCallabe(array(
            'paymentMethodNonce',
            'transactionNo',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'creditpay/' . self::VERSION . '/process';
    }

    /**
     * @param string $paymentMethod
     *
     * @return $this
     */
    public function setPaymentMethod($paymentMethod)
    {
        if (!\in_array($paymentMethod, array('credit_card', 'paypal_account', 'venmo_account', 'android_pay_card', 'apple_pay_card'), true)) {
            throw new InvalidParamException('The param `paymentMethod` is invalid in process');
        }

        $this->params['paymentMethod'] = $paymentMethod;

        return $this;
    }
}
