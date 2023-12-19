<?php

namespace Yuansfer\Api;

use Yuansfer\ApiInterface;

/**
 * Class Cancel
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.pockyt.io/in-store-apis/cancel-api
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
        return 'app-data-search/v3/cancel';
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
