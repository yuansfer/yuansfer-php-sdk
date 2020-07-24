<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;


/**
 * Class Refund
 *
 * @package Yuansfer\Api
 * @author  Feng Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/#refund
 *
 * @method $this setRefundReference(string $refundReference)
 */
class Refund extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            array('amount', 'rmbAmount'),
            array('reference', 'transactionNo'),
        ));

        $this->addCallabe(array(
            'refundReference',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'app-data-search:refund';
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
        unset($this->params['rmbAmount']);

        return $this;
    }

    /**
     * @param number $amount
     *
     * @return $this
     */
    public function setRmbAmount($amount)
    {
        if (!\is_numeric($amount)) {
            throw new InvalidParamException('The param `rmbAmount` is invalid in securepay');
        }

        $this->params['rmbAmount'] = $amount;
        unset($this->params['amount']);

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
