<?php


namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class Pay
 *
 * @package Yuansfer\Api
 * @author  Feng Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/#pay
 *
 * @method $this setStoreAdminNo(string $storeAdminNo)
 * @method $this setPaymentBarcode(string $paymentBarcode)
 */
class Pay extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            array('transactionNo', 'reference'),
            'paymentBarcode',
            'vendor',
        ));

        $this->addCallabe(array(
            'storeAdminNo',
            'paymentBarcode'
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'app-instore:pay';
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
        if (!\in_array($vendor, array('alipay', 'wechatpay', 'unionpay'), true)) {
            throw new InvalidParamException('The param `vender` is invalid in pay');
        }

        $this->params['vendor'] = $vendor;

        return $this;
    }
}
