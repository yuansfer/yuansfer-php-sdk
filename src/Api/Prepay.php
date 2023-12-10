<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class Prepay
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.pockyt.io/in-store-apis/customer-presented-workflow/pay-transaction-api
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

        $this->addCallable(array(
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
        return 'micropay/v3/prepay';
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

        return $this->setParams('terminal', $terminal);
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
            $this->setParams('timeout', $timeout);
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

        return $this->setParams('vendor', $vendor);
    }
}
