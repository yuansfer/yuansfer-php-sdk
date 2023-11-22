<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;


/**
 * Class Refund
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.pockyt.io/refund-and-query-apis/refund-api
 *
 * @method $this setRefundReference(string $refundReference)
 */
class Refund extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'refundAmount',
            'currency',
            'settleCurrency',
            array('reference', 'transactionNo'),
        ));

        $this->addCallable(array(
            'refundReference',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'app-data-search/' . self::VERSION . '/refund';
    }

    /**
     * @deprecated
     * @param number $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        return $this->setRefundAmount($amount);
    }

    /**
     * @param number $amount
     *
     * @return $this
     */
    public function setRefundAmount($amount)
    {
        if (!\is_numeric($amount)) {
            throw new InvalidParamException('The param `refundAmount` is invalid in refund');
        }

        return $this->setParams('refundAmount', $amount);
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        return $this->setParams('currency', \strtoupper($currency));
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setSettleCurrency($currency)
    {
        return $this->setParams('settleCurrency', \strtoupper($currency));
    }

    /**
     * @param string $reference
     *
     * @return $this
     */
    public function setReference($reference)
    {
        unset($this->params['transactionNo']);

        return $this->setParams('reference', $reference);
    }

    /**
     * @param string $transactionNo
     *
     * @return $this
     */
    public function setTransactionNo($transactionNo)
    {
        unset($this->params['reference']);

        return $this->setParams('transactionNo', $transactionNo);
    }
}
