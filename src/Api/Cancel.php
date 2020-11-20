<?php

namespace Yuansfer\Api;

use Yuansfer\ApiInterface;

/**
 * Class Cancel
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/api-reference-v3/transaction-revert/cancel
 */
class Cancel extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            array('reference', 'transactionNo'),
        ));


        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'app-data-search/' . ApiInterface::VERSION . '/cancel';
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
