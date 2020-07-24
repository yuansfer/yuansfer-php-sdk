<?php

namespace Yuansfer\Api;


use Yuansfer\Exception\InvalidParamException;

/**
 * Class CashierAdd
 *
 * @package Yuansfer\Api
 * @author  Feng Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/#cashier_add
 *
 * @method $this setStoreAdminNo(string $storeAdminNo)
 * @method $this setReference(string $reference)
 * @method $this setIpnUrl(string $ipnUrl)
 */
class CashierAdd extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'amount',
            'currency',
            'reference',
            'ipnUrl',
        ));

        $this->addCallabe(array(
            'storeAdminNo',
            'reference',
            'ipnUrl',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'app-data-search:cashier-add';
    }

    /**
     * @param number $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        if (!\is_numeric($amount)) {
            throw new InvalidParamException('The param `amount` is invalid in create-trans-qrcode');
        }

        $this->params['amount'] = $amount;

        return $this;
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->params['currency'] = \strtoupper($currency);

        return $this;
    }
}
