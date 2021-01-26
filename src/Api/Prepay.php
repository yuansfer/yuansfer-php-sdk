<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class Prepay
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/api-reference-v3/payments/online-payment/prepay
 *
 * @method $this setDescription(string $description)
 * @method $this setIpnUrl(string $ipnUrl)
 * @method $this setNote(string $note)
 * @method $this setReference(string $reference)
 * @method $this setOpenid(string $openid)
 */
class Prepay extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'amount',
            'currency',
            'settleCurrency',
            'vendor',
            'ipnUrl',
            'callbackUrl',
            'terminal',
            'reference',
        ));

        $this->addCallabe(array(
            'description',
            'ipnUrl',
            'note',
            'reference',
            'openid',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'micropay/' . self::VERSION . '/prepay';
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

    /**
     * @param string $terminal
     *
     * @return $this
     * @throws InvalidParamException
     */
    public function setTerminal($terminal)
    {
        $terminal = \strtoupper($terminal);

        if (!\in_array($terminal, array('MINIPROGRAM', 'APP'), true)) {
            throw new InvalidParamException('The param `terminal` is invalid in prepay');
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
        if (!\in_array($vendor, array('alipay', 'wechatpay', 'paypal', 'venmo'), true)) {
            throw new InvalidParamException('The param `vender` is invalid in prepay');
        }

        $this->params['vendor'] = $vendor;

        return $this;
    }
}
