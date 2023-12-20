<?php

namespace Yuansfer\Api;

/**
 * Class YipOrderProcess
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.pockyt.io/pockyt-integrated-payments/process-api
 *
 * @method $this setTransactionNo(string $transactionNo)
 */
class YipOrderProcess extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'transactionNo',
        ));

        $this->addCallable(array(
            'transactionNo',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'order/v4/process';
    }

    protected function paramsHook($params)
    {
        $params['timestamp'] = \gmdate("Y-m-d\TH:i:s\Z");

        return $params;
    }
}
