<?php

namespace Yuansfer\Api;


use Yuansfer\Exception\InvalidParamException;

/**
 * Class SettleList
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/api-reference-v3/transaction-data-search/settle-list
 *
 * @method $this setStoreAdminNo(string $storeAdminNo)
 */
class SettleList extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'startDate',
            'endDate',
        ));

        $this->addCallabe(array(
            'storeAdminNo',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'app-data-search/' . self::VERSION . '/settle-list';
    }

    /**
     * @param string $startDate
     *
     * @return $this
     */
    public function setStartDate($startDate)
    {
        if (!\preg_match('/^\d{8}$/', $startDate)) {
            throw new InvalidParamException('The param `startDate` is invalid in settle-list');
        }

        $this->params['startDate'] = $startDate;

        return $this;
    }

    /**
     * @param string $endDate
     *
     * @return $this
     */
    public function setEndDate($endDate)
    {
        if (!\preg_match('/^\d{8}$/', $endDate)) {
            throw new InvalidParamException('The param `endDate` is invalid in settle-list');
        }

        $this->params['endDate'] = $endDate;

        return $this;
    }
}
