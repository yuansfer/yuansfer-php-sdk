<?php

namespace Yuansfer\Api;

use Httpful\Httpful;
use Httpful\Mime;
use Httpful\Request;
use Httpful\Handlers\FormHandler;
use Httpful\Handlers\JsonHandler;
use Httpful\Exception\ConnectionErrorException;

use Yuansfer\ApiInterface;
use Yuansfer\Exception\BadMethodCallException;
use Yuansfer\Exception\InvalidArgumentException;
use Yuansfer\Yuansfer;
use Yuansfer\Util\Sign;
use Yuansfer\Exception\HttpErrorException;
use Yuansfer\Exception\RequiredEmptyException;
use Yuansfer\Exception\YuansferException;
use Yuansfer\Exception\HttpClientException;

/**
 * Class AbstractApi
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 *
 * @method $this setMerchantNo(string $merchantNo)
 * @method $this setStoreNo(string $storeNo)
 */
abstract class AbstractApi implements ApiInterface
{
    /**
     * @var Yuansfer
     */
    protected $yuansfer;

    /**
     * @var array
     */
    protected $params = array();

    protected $required = array(
        'merchantNo',
        'storeNo',
    );

    protected $callable = array(
        'merchantNo',
        'storeNo',
    );

    public function __construct($yuansfer)
    {
        $this->yuansfer = $yuansfer;

        if (!Httpful::hasParserRegistered(Mime::JSON)) {
            Httpful::register(Mime::JSON, new JsonHandler(array('decode_as_array' => true)));
        }

        if (!Httpful::hasParserRegistered(Mime::FORM)) {
            Httpful::register(Mime::FORM, new FormHandler());
        }
    }

    /**
     * @param array|string $fields
     */
    protected function addRequired($fields)
    {
        $this->required = \array_unique(
            \array_merge($this->required, (array) $fields), \SORT_REGULAR
        );
    }

    /**
     * @param array|string $fields
     */
    protected function addCallabe($fields)
    {
        $this->callable = \array_unique(
            \array_merge($this->callable, (array) $fields), \SORT_REGULAR
        );
    }

    /**
     * @return string
     */
    abstract protected function getPath();

    /**
     * @return array
     */
    protected function getRequired()
    {
        return $this->required;
    }

    /**
     * @return string
     */
    protected function responseType()
    {
        return 'json';
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (\strpos($name, 'set') === 0) {
            if (empty($arguments)) {
                throw new InvalidArgumentException('Arguments is empty');
            }

            $key = \lcfirst(\substr($name, 3));

            if (\in_array($key, $this->callable, true)) {
                $this->params[$key] = $arguments[0];

                return $this;
            }
        }

        throw new BadMethodCallException("Method `$name` not exists");
    }

    /**
     * @return string|array
     *
     * @throws YuansferException
     */
    public function send()
    {
        $path = $this->getPath();
        $url = $this->yuansfer->getUrl() . '/' . $path;

        if (!isset($this->params['merchantNo'])) {
            $this->params['merchantNo'] = $this->yuansfer->getMerchantNo();
        }

        if (!isset($this->params['storeNo'])) {
            $this->params['storeNo'] = $this->yuansfer->getStoreNo();
        }

        foreach ($this->getRequired() as $k) {
            $found = false;
            if (\is_array($k)) {
                foreach ($k as $v) {
                    if (!isset($this->params[$v])) {
                        continue;
                    }

                    if (!$found && $this->params[$v] !== '') {
                        $found = true;
                    } else {
                        unset($this->params[$v]);
                    }
                }
            } else {
                $found = isset($this->params[$k]) && $this->params[$k] !== '';
            }

            if (!$found) {
                throw new RequiredEmptyException($path, $k);
            }
        }

        $params = Sign::append($this->params, $this->yuansfer->getApiToken());

        try {
            $response = Request::post($url, $params, 'form')
                ->addHeader('Accept', 'application/json')
                ->expects($this->responseType())
                ->send();

            $code = $response->code;
            if ($code < 200 || $code >= 300) {
                throw new HttpErrorException($response);
            }

            return $response->body;
        } catch (ConnectionErrorException $e) {
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
