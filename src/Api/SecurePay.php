<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class SecurePay
 *
 * @package Yuansfer\Api
 * @author  Feng Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/#secure_pay
 *
 * @method $this setCallbackUrl(string $callbackUrl)
 * @method $this setDescription(string $description)
 * @method $this setIpnUrl(string $ipnUrl)
 * @method $this setNote(string $note)
 * @method $this setReference(string $reference)
 * @method $this setPaymentCount(string $paymentCount)
 * @method $this setFrequency(string $frequency)
 * @method $this setCustomerNo(string $customerNo)
 */
class SecurePay extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            array('amount', 'rmbAmount'),
            'currency',
            'vendor',
            'ipnUrl',
            'callbackUrl',
            'terminal',
            'reference',
        ));

        $this->addCallabe(array(
            'callbackUrl',
            'description',
            'ipnUrl',
            'note',
            'reference',
            'paymentCount',
            'frequency',
            'customerNo',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'online:secure-pay';
    }

    /**
     * @param number $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        if (!\is_numeric($amount)) {
            throw new InvalidParamException('The param `amount` is invalid in securepay');
        }

        $this->params['amount'] = $amount;
        unset($this->params['rmbAmount']);

        return $this;
    }

    /**
     * @param number $amount
     *
     * @return $this
     */
    public function setRmbAmount($amount)
    {
        if (!\is_numeric($amount)) {
            throw new InvalidParamException('The param `rmbAmount` is invalid in securepay');
        }

        $this->params['rmbAmount'] = $amount;
        unset($this->params['amount']);

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
     * @param string $terminal
     *
     * @return $this
     * @throws InvalidParamException
     */
    public function setTerminal($terminal)
    {
        $terminal = \strtoupper($terminal);

        if (!\in_array($terminal, array('ONLINE', 'WAP'), true)) {
            throw new InvalidParamException('The param `terminal` is invalid in securepay');
        }

        $this->params['terminal'] = $terminal;

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

    /**
     * @param string $vendor
     *
     * @return $this
     * @throws InvalidParamException
     */
    public function setVendor($vendor)
    {
        if (!\in_array($vendor, array('alipay', 'wechatpay', 'unionpay', 'creditcard'), true)) {
            throw new InvalidParamException('The param `vender` is invalid in securepay');
        }

        $this->params['vendor'] = $vendor;

        return $this;
    }

    /**
     * @param array $goodsInfo
     *
     * @return $this
     */
    public function setGoodsInfo($goodsInfo)
    {
        $this->params['goodsInfo'] = \json_encode($goodsInfo);

        return $this;
    }

    /**
     * @param string $creditType
     *
     * @return $this
     */
    public function setCreditType($creditType)
    {
        if (!\in_array($creditType, array('normal', 'recurring'), true)) {
            throw new InvalidParamException('The param `creditType` is invalid in securepay');
        }

        $this->params['creditType'] = $creditType;

        return $this;
    }
}
