<?php


namespace Yuansfer\Api;

/**
 * Class PayeeRegister
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>

 * @method $this setZip(string $zip)
 * @method $this setFirstName(string $firstName)
 * @method $this setLastName(string $lastName)
 * @method $this setCustomerCode(string $customerCode)
 * @method $this setEmail(string $email)
 * @method $this setCountryCode(string $zip)
 * @method $this setCountry(string $country)
 * @method $this setCity(string $city)
 * @method $this setDateOfBirth(string $dateOfBirth)
 * @method $this setPhone(string $phone)
 * @method $this setStreet(string $street)
 * @method $this setStreet2(string $street2)
 * @method $this setState(string $state)
 * @method $this setLang(string $lang)
 * @method $this setProfileType(string $profileType)
 */
class PayeeRegister extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'profileType',
            'dateOfBirth',
            'customerCode',
            'email',
            'phone',
            'firstName',
            'lastName',
            'countryCode',
            'state',
            'city',
            'street',
            'zip',
            'lang',
        ));

        $this->addCallable(array(
            'profileType',
            'dateOfBirth',
            'customerCode',
            'email',
            'phone',
            'firstName',
            'lastName',
            'countryCode',
            'country',
            'state',
            'city',
            'street',
            'street2',
            'zip',
            'lang',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'v3/payee/register';
    }

    protected function paramsHook($params)
    {
        $params['timestamp'] = \gmdate("Y-m-d\TH:i:s\Z");
        return $params;
    }
}
