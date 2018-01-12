<?php

namespace Yuansfer\Util;

/**
 * Class Sign
 *
 * @package Yuansfer
 * @author Feng Hao <flyinghail@msn.com>
 */
class Sign
{

    /**
     * @param array $params
     *
     * @return string
     */
    protected static function generate(&$params, $token)
    {
        unset($params['verifySign']);

        \ksort($params, SORT_STRING);
        $str = '';
        foreach ($params as $k => $v) {
            $str .= $k . '=' . $v . '&';
        }

        return \md5($str . \md5($token));
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public static function append($params, $token)
    {
        $params['verifySign'] = static::generate($params, $token);

        return $params;
    }

    /**
     * @param array $params
     *
     * @return bool
     */
    public static function verify($params, $token)
    {
        if (!isset($params['verifySign'])) {
            return false;
        }

        $verifySign = $params['verifySign'];

        return $verifySign === static::generate($params, $token);
    }
}