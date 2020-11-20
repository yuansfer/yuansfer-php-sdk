<?php

namespace Yuansfer;

use Yuansfer\Exception\YuansferException;

/**
 * Interface ApiInterface
 *
 * @package Yuansfer
 * @author FENG Hao <flyinghail@msn.com>
 */
interface ApiInterface
{
    const VERSION = 'v3';

    /**
     * @return string
     * @throws YuansferException
     */
    public function send();
}
