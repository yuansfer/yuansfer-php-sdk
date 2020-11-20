<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class DataStatus
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/api-reference-v3/transaction-data-search/data-status
 *
 * @method $this setStoreAdminNo(string $storeAdminNo)
 */
class DataStatus extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'paymentDate',
        ));

        $this->addCallabe(array(
            'storeAdminNo',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'app-data-search/' . self::VERSION . '/data-status';
    }

    /**
     * @param string $paymentDate
     *
     * @return $this
     */
    public function setPaymentDate($paymentDate)
    {
        if (!\preg_match('/^\d{8}$/', $paymentDate)) {
            throw new InvalidParamException('The param `paymentDate` is invalid in data-status');
        }

        $this->params['paymentDate'] = $paymentDate;

        return $this;
    }
}
