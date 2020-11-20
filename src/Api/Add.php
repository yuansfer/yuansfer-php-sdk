<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class Add
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/api-reference-v3/payments/in-store-payment/scan-qrcode/add
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

        $this->addCallabe(array(
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

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setSettleCurrency($currency)
    {
        $this->params['settleCurrency'] = \strtoupper($currency);

        return $this;
    }
}
