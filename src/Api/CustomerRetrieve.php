<?php


namespace Yuansfer\Api;

/**
 * Class CustomerRetrieve
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 *
 * @method $this setCustomerCode(string $customerCode)
 * @method $this setCustomerNo(string $customerNo)
 */
class CustomerRetrieve extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'customerCode',
            'customerNo'
        ));

        $this->addCallable(array(
            'customerCode',
            'customerNo',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'v1/customers/retrieve';
    }

    protected function paramsHook($params)
    {
        $params['timestamp'] = \gmdate("Y-m-d\TH:i:s\Z");
        return $params;
    }
}
