<?php


namespace Yuansfer\Api;

/**
 * Class CustomerQuery
 *
 * @package Yuansfer\Api
 * @author  Feng Hao <flyinghail@msn.com>
 */
class CustomerQuery extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            array('customerCode', 'customerNo')
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'creditpay:customer/detail';
    }

    /**
     * @param string $customerCode
     *
     * @return $this
     */
    public function setCustomerCode($customerCode)
    {
        $this->params['customerCode'] = $customerCode;
        unset($this->params['customerNo']);

        return $this;
    }

    /**
     * @param string $customerCode
     *
     * @return $this
     */
    public function setCustomerNo($customerNo)
    {
        $this->params['customerNo'] = $customerNo;
        unset($this->params['customerCode']);

        return $this;
    }
}
