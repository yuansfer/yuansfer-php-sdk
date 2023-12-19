<?php

namespace Yuansfer\Api;

use Yuansfer\Util\GoodsInfo;

/**
 * Class YipOrderCapture
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.pockyt.io/pockyt-integrated-payments/process-api
 *
 * @method $this setCustomerNo(string $customerNo)
 * @method $this setCurrency(string $currency)
 * @method $this setSettleCurrency(string $settleCurrency)
 * @method $this setAmount(string $amount)
 * @method $this setVendor(string $vendor)
 * @method $this setReference(string $reference)
 * @method $this setIpnUrl(string $ipnUrl)
 * @method $this setNote(string $note)
 * @method $this setTerminal(string $terminal)
 * @method $this setCardNumber(string $cardNumber)
 * @method $this setCardExpYear(string $cardExpYear)
 * @method $this setCardExpMonth(string $cardExpMonth)
 * @method $this setCardCvv(string $cardCvv)
 * @method $this setClientIp(string $clientIp)
 */
class YipOrderCapture extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'currency',
            'settleCurrency',
            'amount',
            'vendor',
            'reference',
            'terminal',
            'cardNumber',
            'cardExpYear',
            'cardExpMonth',
        ));

        $this->addCallable(array(
            'customerNo',
            'currency',
            'settleCurrency',
            'amount',
            'vendor',
            'reference',
            'ipnUrl',
            'note',
            'terminal',
            'cardNumber',
            'cardExpYear',
            'cardExpMonth',
            'cardCvv',
            'clientIp',
            'goodesInfo',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'order/v4/capture';
    }

    /**
     * @return GoodsInfo
     */
    public function newGoodsInfo()
    {
        $this->params['goodsInfo'] = new GoodsInfo();

        return $this->params['goodsInfo'];
    }

    /**
     * @param $goodsName string
     * @param $quantity int
     * @param $amount int
     * @param $category string
     * @param $description string
     * @param $tax string
     * @return $this
     */
    public function setGoodsInfo($goodsName, $quantity, $amount, $category, $description, $tax = "")
    {
        $goodsInfo = $this->newGoodsInfo();
        $goodsInfo->setGoodsName($goodsName);
        $goodsInfo->setQuantity($quantity);
        $goodsInfo->setAmount($amount);
        $goodsInfo->setCategory($category);
        $goodsInfo->setDescription($description);
        $goodsInfo->setTax($tax);

        return $this;
    }

    protected function paramsHook($params)
    {
        if ($params['goodsInfo'] instanceof GoodsInfo) {
            $params['goodsInfo'] = $params['goodsInfo']->toString($this->getPath(), 'goodsInfo');
        }

        return $params;
    }
}
