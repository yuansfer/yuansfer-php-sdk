<?php


namespace Yuansfer\Api;

/**
 * Class CustomerQuery
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
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
        return 'creditpay/v2/customer/detail';
    }

    /**
     * @param string $customerCode
     *
     * @return $this
     */
    public function setCustomerCode($customerCode)
    {
        unset($this->params['customerNo']);

        return $this->setParams('customerCode', $customerCode);
    }

    /**
     * @param string $customerCode
     *
     * @return $this
     */
    public function setCustomerNo($customerNo)
    {
        unset($this->params['customerCode']);

        return $this->setParams('customerNo', $customerNo);
    }
}
