<?php


namespace Yuansfer\Api;

/**
 * Class PayoutPay
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>

 * @method $this setCustomerNo(string $customerNo)
 * @method $this setAccountToken(string $accountToken)
 * @method $this setInvoiceId(string $invoiceId)
 * @method $this setAmount(string $amount)
 * @method $this setCurrency(string $currency)
 * @method $this setIpcUrl(string $ipcUrl)
 * @method $this setDescription(string $description)
 * @method $this setNote(string $note)
 * @method $this setSubject(string $subject)
 * @method $this setProcessingChannel(string $processingChannel)
 */
class PayoutPay extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'customerNo',
            'accountToken',
            'invoiceId',
            'amount',
            'currency',
        ));

        $this->addCallable(array(
            'customerNo',
            'accountToken',
            'invoiceId',
            'amount',
            'currency',
            'ipcUrl',
            'description',
            'note',
            'subject',
            'processingChannel',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'v3/payouts/pay';
    }

    protected function paramsHook($params)
    {
        $params['timestamp'] = \gmdate("Y-m-d\TH:i:s\Z");
        return $params;
    }
}
