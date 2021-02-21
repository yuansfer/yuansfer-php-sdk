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

        if (!\in_array($terminal, array('ONLINE', 'WAP', 'MWEB', 'YIP'), true)) {
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

        return $this->validate('terminal');
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
        if (!\in_array($this->params['vendor'], array(
            'alipay', 'wechatpay', 'unionpay', 'creditcard', 'paypal', 'venmo',
            'truemoney', 'alipay_hk', 'tng', 'gcash', 'dana', 'kakaopay', 'bkash', 'easypaisa',
            'googlepay', 'applepay'
        ), true)) {
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
                return $this->validateVendor()
                    ->validateCurrency()
                    ->validateSettleCurrency()
                    ->validateAmount();
            case 'currency':
                return $this->validateCurrency()
                    ->validateSettleCurrency()
                    ->validateAmount();

            case 'settleCurrency':
                return $this->validateSettleCurrency();

            case 'terminal':
                return $this->validateVendor();

            default:
                return $this;
        }
    }

    protected function validateVendor()
    {
        if (!isset($this->params['terminal'], $this->params['vendor'])) {
            return $this;
        }

        if ($this->params['terminal'] === 'YIP') {
            if (!\in_array($this->params['vendor'], array('paypal', 'venmo', 'creditcard', 'applepay', 'googlepay'), true)) {
                throw new InvalidParamException('"YIP" terminal only support "' . implode('", "', $this->params['vendor']) . '" for vendor');
            }
        } else if (\in_array($this->params['vendor'], array('applepay', 'googlepay'), true)) {
            throw new InvalidParamException('"' . $this->params['vendor'] . '" not supported by "' . $this->params['terminal'] . '" terminal');
        }

        return $this;
    }

    protected function validateCurrency()
    {
        if (!isset($this->params['currency'], $this->params['vendor'])) {
            return $this;
        }

        static $settings = array(
            'creditcard' => array(
                'Credit Card',
                array('USD')
            ),
            'unionpay' => array(
                'Union Pay',
                array('USD', 'CNY')
            ),
            'wechatpay' => array(
                'Wechat Pay',
                array('USD', 'CNY')
            ),
            'alipay' => array(
                'Alipay',
                array('USD', 'CNY', 'GBP')
            ),
            'paypal' => array(
                'Paypal',
                array('USD')
            ),
            'venmo' => array(
                'Venmo',
                array('USD')
            ),
            'truemoney' => array(
                'TrueMoney',
                array('THB')
            ),
            'alipay_hk' => array(
                'Alipay HK',
                array('HKD')
            ),
            'tng' => array(
                'Touch\'n Go',
                array('MYR')
            ),
            'gcash' => array(
                'Gcash',
                array('PHP')
            ),
            'dana' => array(
                'Dana',
                array('IDR')
            ),
            'kakaopay' => array(
                'KakaoPay',
                array('KRW')
            ),
            'bkash' => array(
                'bKash',
                array('BDT')
            ),
            'easypaisa' => array(
                'EasyPaisa',
                array('PKR')
            ),
        );

        if (isset($settings[$this->params['vendor']])) {
            list($name, $currency) = $settings[$this->params['vendor']];
            if (!in_array($this->params['currency'], $currency, true)) {
                throw new InvalidParamException($name . ' only support "' . implode('", "', $currency) . '" for currency');
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

        static $settings = array(
            'PHP' => 1,
            'THB' => 1,
            'MYR' => 1,
            'IDR' => 300,
            'KRW' => 50,
            'HKD' => 0.1,
            'BDT' => 0.01,
            'PKR' => 100,
        );

        if (
            isset($settings[$this->params['currency']]) &&
            $this->params['amount'] < $settings[$this->params['currency']]
        ) {
            throw new InvalidParamException('The minimum value is ' . $settings[$this->params['currency']] . $this->params['currency']);
        }

        return $this;
    }
}
