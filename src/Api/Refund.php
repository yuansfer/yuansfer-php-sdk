<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;


/**
 * Class Refund
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/api-reference-v3/transaction-revert/refund
 *
 * @method $this setRefundReference(string $refundReference)
 */
class Refund extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'amount',
            'currency',
            'settleCurrency',
            array('reference', 'transactionNo'),
        ));

        $this->addCallabe(array(
            'refundReference',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'app-data-search/' . self::VERSION . '/refund';
    }

    /**
     * @param number $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        if (!\is_numeric($amount)) {
            throw new InvalidParamException('The param `amount` is invalid in securepay');
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

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setSettleCurrency($currency)
    {
        $this->params['settleCurrency'] = \strtoupper($currency);

        return $this;
    }

    /**
     * @param string $reference
     *
     * @return $this
     */
    public function setReference($reference)
    {
        $this->params['reference'] = $reference;
        unset($this->params['transactionNo']);

        return $this;
    }

    /**
     * @param string $transactionNo
     *
     * @return $this
     */
    public function setTransactionNo($transactionNo)
    {
        $this->params['transactionNo'] = $transactionNo;
        unset($this->params['reference']);

        return $this;
    }
}
