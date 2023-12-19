<?php

namespace Yuansfer\Api;

/**
 * Class YipSecurePayVault
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.pockyt.io/pockyt-integrated-payments/process-api
 *
 * @method $this setCreditType(string $creditType)
 */
class YipSecurePayVault extends YipSecurePay
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'creditType',
        ));

        $this->addCallable(array(
            'creditType',
        ));

        parent::__construct($yuansfer);
    }
}
