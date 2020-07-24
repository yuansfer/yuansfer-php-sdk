<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class ExpressPay
 *
 * @package Yuansfer\Api
 * @author  Feng Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/#express_pay
 *
 * @method $this setCardNumber(string $cardNumber)
 * @method $this setCardCvv(string $cardCvv)
 * @method $this setClientIp(string $clientIp)
 * @method $this setReference(string $reference)
 */
class ExpressPay extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'cardNumber',
            'cardExpYear',
            'cardExpMonth',
            'cardCvv',
            'amount',
            'reference',
            'clientIp',
            'currency',
        ));

        $this->addCallabe(array(
            'cardNumber',
            'cardCvv',
            'clientIp',
            'reference'
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'micropay:express-pay';
    }

    /**
     * @param string $cardExpYear
     *
     * @return $this
     */
    public function setCardExpYear($cardExpYear)
    {
        if (!\preg_match('/^\d{4}$/', $cardExpYear)) {
            throw new InvalidParamException('The param `cardExpYear` is invalid in express-pay');
        }

        $this->params['cardExpYear'] = $cardExpYear;

        return $this;
    }

    /**
     * @param string $cardExpMonth
     *
     * @return $this
     */
    public function setCardExpMonth($cardExpMonth)
    {
        if (!\preg_match('/^\d{2}$/', $cardExpMonth)) {
            throw new InvalidParamException('The param `cardExpMonth` is invalid in express-pay');
        }

        $this->params['cardExpMonth'] = $cardExpMonth;

        return $this;
    }

    /**
     * @param number $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        if (!\is_numeric($amount)) {
            throw new InvalidParamException('The param `amount` is invalid in express-pay');
        }

        $this->params['amount'] = $amount;

        return $this;
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->params['currency'] = \strtoupper($currency);

        return $this;
    }
}
