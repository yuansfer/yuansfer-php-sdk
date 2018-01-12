<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class Pay
 *
 * @package Yuansfer\Api
 * @author  Feng Hao <flyinghail@msn.com>
 */
class SecurePay extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'amount',
            'currency',
            'vendor',
            'ipnUrl',
            'callbackUrl',
            'terminal',
            'reference',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'securepay';
    }

    protected function responseType()
    {
        return 'html';
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

        return $this;
    }

    /**
     * @param string $callbackUrl
     *
     * @return $this
     */
    public function setCallbackUrl($callbackUrl)
    {
        $this->params['callbackUrl'] = $callbackUrl;

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
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->params['description'] = $description;

        return $this;
    }

    /**
     * @param string $ipnUrl
     *
     * @return $this
     */
    public function setIpnUrl($ipnUrl)
    {
        $this->params['ipnUrl'] = $ipnUrl;

        return $this;
    }

    /**
     * @param string $merchantNo
     *
     * @return $this
     */
    public function setMerchantNo($merchantNo)
    {
        $this->params['merchantNo'] = $merchantNo;

        return $this;
    }

    /**
     * @param string $note
     *
     * @return $this
     */
    public function setNote($note)
    {
        $this->params['note'] = $note;

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

        return $this;
    }

    /**
     * @param string $storeNo
     *
     * @return $this
     */
    public function setStoreNo($storeNo)
    {
        $this->params['storeNo'] = $storeNo;

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
        if (!\in_array($vendor, array('alipay', 'wechatpay', 'unionpay'), true)) {
            throw new InvalidParamException('The param `vender` is invalid in securepay');
        }

        $this->params['vendor'] = $vendor;

        return $this;
    }

}