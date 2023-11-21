<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class Add
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.pockyt.io/in-store-apis/customer-presented-workflow/add-transaction-api
 *
 * @method $this setStoreAdminNo(string $storeAdminNo)
 * @method $this setReference(string $reference)
 */
class Add extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'amount',
            'currency',
            'settleCurrency',
        ));

        $this->addCallable(array(
            'storeAdminNo',
            'reference',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'app-instore/' . self::VERSION . '/add';
    }

    /**
     * @param number $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        if (!\is_numeric($amount)) {
            throw new InvalidParamException('The param `amount` is invalid in add');
        }

        return $this->setParams('amount', $amount);
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
}
