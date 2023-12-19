<?php
namespace Yuansfer\Util;

use Yuansfer\Exception\RequiredEmptyException;

/**
* Class GoodsInfo
*
* @package Yuansfer
* @author FENG Hao <flyinghail@msn.com>
*/
class GoodsInfo
{
    protected $params = array();
    protected $required = array(
        'goods_name',
        'quantity',
        'amount',
        'category',
    );

    public function setGoodsName($goodsName)
    {
        $this->params['goods_name'] = $goodsName;
        return $this;
    }

    public function setQuantity($quantity)
    {
        $this->params['quantity'] = $quantity;
        return $this;
    }

    public function setAmount($amount)
    {
        $this->params['amount'] = $amount;
        return $this;
    }

    public function setCategory($category)
    {
        $this->params['category'] = $category;
        return $this;
    }

    public function setDescription($description)
    {
        $this->params['description'] = $description;
        return $this;
    }

    public function setTax($tax)
    {
        $this->params['tax'] = $tax;
        return $this;
    }

    public function toString($path, $key)
    {
        foreach ($this->required as $k) {
            if (empty($this->params[$k])) {
                throw new RequiredEmptyException($path, "{$key}.{$k}");
            }
        }

        return \json_encode($this->params);
    }
}