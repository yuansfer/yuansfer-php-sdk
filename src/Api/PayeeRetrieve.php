<?php


namespace Yuansfer\Api;

/**
 * Class PayeeRetrieve
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 *
 * @method $this setCustomerCode(string $customerCode)
 * @method $this setCustomerNo(string $customerNo)
 */
class PayeeRetrieve extends AbstractApi
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
        return 'v3/payee/retrieve';
    }

    protected function paramsHook($params)
    {
        $params['timestamp'] = \gmdate("Y-m-d\TH:i:s\Z");
        return $params;
    }
}
