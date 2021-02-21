<?php

namespace Yuansfer;

use Yuansfer\Api\WithdrawalList;
use Yuansfer\Exception\BadMethodCallException;
use Yuansfer\Exception\InvalidArgumentException;
use Yuansfer\Util\Sign;


/**
 * Class Yuansfer
 *
 * @package Yuansfer
 * @author  FENG Hao <flyinghail@msn.com>
 *
 * Checkout
 * @method Api\SecurePay createSecurePay()
 *
 * Yuansfer Integrated Payment
 * @method Api\Process createProcess()
 * @method Api\Prepay createPrepay()
 *
 * Point of Sale Integration
 * * Scan QR Code
 * @method Api\Add createAdd()
 * @method Api\Pay createPay()
 * * Create QR Code
 * @method Api\TransQrcode createTransQrcode()
 *
 *
 * Transaction Revert
 * @method Api\Refund createRefund()
 * @method Api\Cancel createCancel()
 *
 * Transaction Data Search
 * @method Api\TranQuery createTranQuery()
 * @method Api\TransList createTransList()
 * @method Api\SettleList createSettleList()
 * @method Api\WithdrawalList createWithdrawalList()
 * @method Api\DataStatus createDataStatus()
 *
 * Customer
 * @method Api\CustomerAdd createCustomerAdd()
 * @method Api\CustomerQuery createCustomerQuery()
 * @method Api\CustomerUpdate createCustomerUpdate()
 */
class Yuansfer
{
    const
        MERCHANT_NO = 'merchant_no',
        STORE_NO = 'store_no',
        API_TOKEN = 'api_token',
        TEST_API_TOKEN = 'test_api_token';

    const
        PRODUCTION_MODE = 'production',
        TEST_MODE = 'test';

    const PRODUCTION_URL = 'https://mapi.yuansfer.com',
        TEST_URL = 'https://mapi.yuansfer.yunkeguan.com';

    /**
     * @var string The merchant NO.
     */
    protected $merchantNo;

    /**
     * @var string The store NO.
     */
    protected $storeNo;

    /**
     * @var string Yuansfer token
     */
    protected $apiToken;

    /**
     * @var string Yuansfer token for test mode
     */
    protected $testApiToken;

    /**
     * @var string password for refund
     */
    protected $password;

    /**
     * @var string api mode
     */
    private $mode;

    /**
     * Config constructor.
     *
     * @param array $config
     */
    public function __construct($config)
    {
        foreach ($config as $k => $v) {
            switch ($k) {
                case static::MERCHANT_NO:
                    $this->setMerchantNo($v);
                    break;

                case static::STORE_NO:
                    $this->setStoreNo($v);
                    break;

                case static::API_TOKEN:
                    $this->setApiToken($v);
                    break;

                case static::TEST_API_TOKEN:
                    $this->setTestApiToken($v);
                    break;
            }
        }
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if ($this->isTestMode()) {
            return static::TEST_URL;
        }

        return static::PRODUCTION_URL;
    }

    /**
     * @return string
     */
    public function getMerchantNo()
    {
        return $this->merchantNo;
    }

    /**
     * @param string $no
     *
     * @return self
     */
    public function setMerchantNo($no)
    {
        $this->merchantNo = $no;

        return $this;
    }

    /**
     * @return string
     */
    public function getStoreNo()
    {
        return $this->storeNo;
    }

    /**
     * @param string $no
     *
     * @return self
     */
    public function setStoreNo($no)
    {
        $this->storeNo = $no;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiToken()
    {
        if ($this->isTestMode()) {
            return $this->testApiToken;
        }

        return $this->apiToken;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setApiToken($token)
    {
        $this->apiToken = $token;

        return $this;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setTestApiToken($token)
    {
        $this->testApiToken = $token;

        return $this;
    }

    /**
     * @return $this
     */
    public function setTestMode()
    {
        $this->mode = self::TEST_MODE;

        return $this;
    }

    /**
     * @return $this
     */
    public function setProductionMode()
    {
        $this->mode = self::PRODUCTION_MODE;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTestMode()
    {
        return $this->mode === self::TEST_MODE;
    }

    /**
     * @param array $params
     *
     * @return bool
     */
    public function verifySign($params)
    {
        return Sign::verify($params, $this->getApiToken());
    }

    /**
     * @return bool
     */
    public function verifyIPN()
    {
        return isset($_POST['status'], $_POST['reference']) && $this->verifySign($_POST);
    }

    public function __call($name, $args)
    {
        if (\strpos($name, 'create') === 0) {
            $class = __NAMESPACE__ . '\\Api\\' . \substr($name, 6);
            if (!\class_exists($class)) {
                throw new BadMethodCallException("Method `$name` not exists");
            }

            $api = new $class($this);
            if (!$api instanceof ApiInterface) {
                throw new InvalidArgumentException('API must be instance of Yuansfer\\ApiInterface');
            }

            return $api;
        }

        throw new BadMethodCallException("Method `$name` not exists");
    }
}
