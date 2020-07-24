<?php


namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class TransQrcode
 *
 * @package Yuansfer\Api
 * @author  Feng Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/#create_trans_qrcode
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
            'vendor',
            'amount',
        ));

        $this->addCallabe(array(
            'storeAdminNo',
            'ipnUrl',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'app-instore:create-trans-qrcode';
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

        $this->params['vendor'] = $vendor;

        return $this;
    }

    /**
     * @param bool $needQrcode
     *
     * @return $this
     */
    public function setNeedQrcode($needQrcode)
    {
        $needQrcode = (bool) $needQrcode;
        $this->params['needQrcode'] = $needQrcode ? 'true' : 'false';

        return $this;
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
            $this->params['timeout'] = (int) $timeout;
        }

        return $this;
    }
}
