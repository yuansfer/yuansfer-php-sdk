<?php

namespace Yuansfer\Api;

/**
 * Class SecurePayReferenceQuery
 *
 * @package Yuansfer\Api
 * @author  Feng Hao <flyinghail@msn.com>
 */
class SecurePayReferenceQuery extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array('reference'));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'securepay-reference-query';
    }

    /**
     * @param string $reference
     *
     * @return $this;
     */
    public function setReference($reference)
    {
        $this->params['reference'] = $reference;

        return $this;
    }
}