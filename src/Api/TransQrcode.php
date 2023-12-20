<?php


namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class TransQrcode
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.pockyt.io/in-store-apis/merchant-presented-workflow/create-qrc-api
 *
 * @method $this setStoreAdminNo(string $storeAdminNo)
 * @method $this setIpnUrl(string $ipnUrl)
 */
class TransQrcode extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            array('transactionNo', 'reference'),
            'currency',
            'settleCurrency',
            'vendor',
            'amount',
        ));

        $this->addCallable(array(
            'storeAdminNo',
            'ipnUrl',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'app-instore/v3/create-trans-qrcode';
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

    /**
     * @param string $vendor
     *
     * @return $this
     * @throws InvalidParamException
     */
    public function setVendor($vendor)
    {
        if (!\in_array($vendor, array('alipay', 'wechatpay'), true)) {
            throw new InvalidParamException('The param `vender` is invalid in create-trans-qrcode');
        }

        return $this->setParams('vendor', $vendor);
    }

    /**
     * @param bool $needQrcode
     *
     * @return $this
     */
    public function setNeedQrcode($needQrcode)
    {
        $needQrcode = (bool) $needQrcode;

        return $this->setParams('needQrcode', $needQrcode ? 'true' : 'false');
    }

    /**
     * @param int $timeout
     *
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $timeout = (int) $timeout;

        if ($timeout > 0) {
            return $this->setParams('timeout', $timeout);
        }

        return $this;
    }
}
