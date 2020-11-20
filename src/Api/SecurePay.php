<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class SecurePay
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/api-reference-v3/payments/online-payment/secure-pay
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
    private static $detect;

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
            'callbackUrl',
            'description',
            'ipnUrl',
            'note',
            'reference',
            'paymentCount',
            'frequency',
            'customerNo',
        ));

        self::$detect = new \Mobile_Detect();

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'online/' . self::VERSION . '/secure-pay';
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

        return $this->validate('amount');
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->params['currency'] = \strtoupper($currency);

        return $this->validate('currency');
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setSettleCurrency($currency)
    {
        $this->params['settleCurrency'] = \strtoupper($currency);

        return $this->validate('settleCurrency');
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

        if (!\in_array($terminal, array('ONLINE', 'WAP', 'MWEB'), true)) {
            throw new InvalidParamException('The param `terminal` is invalid in securepay');
        }

        $this->params['terminal'] = $terminal;

        if (!isset($this->params['osType'])) {
            if ($terminal === 'WAP' || $terminal === 'MWEB') {
                $osType = 'ANDROID';
                if (self::$detect->is('iOS') || self::$detect->is('iPadOS')) {
                    $osType = 'IOS';
                }

                $this->setOsType($osType);
            }
        }

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
        if (!\in_array($vendor, array('alipay', 'wechatpay', 'unionpay', 'creditcard', 'paypal', 'venmo'), true)) {
            throw new InvalidParamException('The param `vender` is invalid in securepay');
        }

        $this->params['vendor'] = $vendor;

        if (!isset($this->params['terminal'])) {
            $terminal = self::$detect->isMobile() ? 'WAP' : 'ONLINE';
            if ($vendor === 'wechatpay' && $terminal === 'WAP' && !self::$detect->is('WeChat')) {
                $terminal = 'MWEB';
            }
            $this->setTerminal($terminal);
        }

        return $this->validate('vendor');
    }

    /**
     * @param array $goodsInfo
     *
     * @return $this
     */
    public function setGoodsInfo($goodsInfo)
    {
        if (!is_array($goodsInfo)) {
            throw new InvalidParamException('The param `goodsInfo` must be an array');
        }

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

    /**
     * @param string $osType
     *
     * @return $this
     */
    public function setOsType($osType)
    {
        if (!\in_array($osType, array('IOS', 'ANDROID'), true)) {
            throw new InvalidParamException('The param `osType` is invalid in securepay');
        }

        $this->params['osType'] = $osType;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    protected function validate($key)
    {
        switch ($key) {
            case 'amount':
                return $this->validateAmount();

            case 'vendor':
            case 'currency':
                return $this->validateCurrency()
                    ->validateSettleCurrency()
                    ->validateAmount();

            case 'settleCurrency':
                return $this->validateSettleCurrency();

            default:
                return $this;
        }
    }

    protected function validateCurrency()
    {
        if (!isset($this->params['currency'], $this->params['vendor'])) {
            return $this;
        }

        if ($this->params['vendor'] === 'creditcard') {
            if ($this->params['currency'] !== 'USD') {
                throw new InvalidParamException('Credit Card only support "USD" for currency');
            }
        } elseif ($this->params['vendor'] === 'unionpay') {
            if (!in_array($this->params['currency'], array('USD', 'CNY'), true)) {
                throw new InvalidParamException('Union Pay only support "USD", "CNY" for currency');
            }
        } elseif ($this->params['vendor'] === 'wechatpay') {
            if (!in_array($this->params['currency'], array('USD', 'CNY'), true)) {
                throw new InvalidParamException('WeChat Pay only support "USD", "CNY" for currency');
            }
        } elseif ($this->params['vendor'] === 'alipay') {
            if (!in_array($this->params['currency'], array('USD', 'CNY', 'PHP', 'IDR', 'KRW', 'HKD', 'GBP'), true)) {
                throw new InvalidParamException('Alipay only support “USD“, “CNY“, “PHP“, “IDR“, “KRW“, “HKD“, “GBP“ for currency');
            }
        } elseif (in_array($this->params['vendor'], array('paypal', 'venmo'), true)) {
            if ($this->params['currency'] !== 'USD') {
                throw new InvalidParamException(ucfirst($this->params['vendor']) . ' only support "USD" for currency');
            }
        }

        return $this;
    }

    protected function validateSettleCurrency()
    {
        if (!isset($this->params['currency'], $this->params['vendor'])) {
            return $this;
        }

        if ($this->params['vendor'] !== 'alipay') {
            if ($this->params['settleCurrency'] !== 'USD') {
                throw new InvalidParamException(ucfirst($this->params['vendor']) . ' only support "USD" for settle currency');
            }
        } elseif ($this->params['currency'] === 'GBP') {
            if ($this->params['settleCurrency'] !== 'GBP') {
                throw new InvalidParamException(ucfirst($this->params['vendor']) . ' only support "GBP" for settle currency');
            }
        } elseif ($this->params['currency'] === 'CNY') {
            if (!in_array($this->params['settleCurrency'], array('USD', 'GBP'), true)) {
                throw new InvalidParamException(ucfirst($this->params['vendor']) . ' only support "USD", "GBP" for settle currency');
            }
        }

        return $this;
    }

    protected function validateAmount()
    {
        if (!isset($this->params['amount'], $this->params['currency'], $this->params['vendor']) || $this->params['vendor'] !== 'alipay') {
            return $this;
        }

        switch ($this->params['currency']) {
            case 'PHP':
                if ($this->params['amount'] < 1) {
                    throw new InvalidParamException('The minimum value is 1PHP');
                }
                break;

            case 'IDR':
                if ($this->params['amount'] < 300) {
                    throw new InvalidParamException('The minimum value is 300IDR');
                }
                break;

            case 'KRW':
                if ($this->params['amount'] < 50) {
                    throw new InvalidParamException('The minimum value is 50KRW');
                }
                break;

            case 'HKD':
                if ($this->params['amount'] < 0.1) {
                    throw new InvalidParamException('The minimum value is 0.1HKD');
                }
                break;
        }

        return $this;
    }
}
