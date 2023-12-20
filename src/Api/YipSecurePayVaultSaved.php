<?php

namespace Yuansfer\Api;

/**
 * Class YipSecurePayVaultSaved
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 * @see     https://docs.pockyt.io/pockyt-integrated-payments/process-api
 *
 * @method $this setVaultId(string $vaultId)
 */
class YipSecurePayVaultSaved extends YipSecurePayVault
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'vaultId',
        ));

        $this->addCallable(array(
            'vaultId',
        ));

        parent::__construct($yuansfer);
    }
}
