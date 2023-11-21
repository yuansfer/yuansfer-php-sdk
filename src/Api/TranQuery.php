<?php

namespace Yuansfer\Api;


/**
 * Class TranQuery
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.pockyt.io/refund-and-query-apis/query-api
 */
class TranQuery extends AbstractApi
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
        return 'app-data-search/' . self::VERSION . '/tran-query';
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
