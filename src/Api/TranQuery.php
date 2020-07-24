<?php

namespace Yuansfer\Api;


/**
 * Class TranQuery
 *
 * @package Yuansfer\Api
 * @author  Feng Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/#tran_query
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
        return 'app-data-search:tran-query';
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
