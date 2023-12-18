<?php


namespace Yuansfer\Api;

/**
 * Class PayeeAddBank
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 *
 * @method $this setCustomerNo(string $customerNo)
 * @method $this setAccountCountry(string $accountCountry)
 * @method $this setAccountCurrency(string $accountCurrency)
 * @method $this setAccountType(string $accountType)
 * @method $this setAccountTag(string $accountTag)
 * @method $this setBankAccountId(string $bankAccountId)
 * @method $this setBranchId(string $branchId)
 * @method $this setBankAccountPurpose(string $bankAccountPurpose)
 * @method $this setClientIp(string $clientIp)
 * @method $this setIpnUrl(string $ipnUrl)
 */
class PayeeAddBank extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'customerNo',
            'accountCountry',
            'accountCurrency',
            'accountType',
            'bankAccountId',
            'branchId',
            'bankAccountPurpose',
        ));

        $this->addCallable(array(
            'customerNo',
            'accountCountry',
            'accountCurrency',
            'accountType',
            'accountTag',
            'bankAccountId',
            'branchId',
            'bankAccountPurpose',
            'clientIp',
            'ipnUrl',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return '3/payee/update';
    }

    protected function paramsHook($params)
    {
        $params['timestamp'] = \gmdate("Y-m-d\TH:i:s\Z");
        return $params;
    }
}
