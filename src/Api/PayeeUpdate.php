<?php


namespace Yuansfer\Api;

/**
 * Class PayeeUpdate
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 *
 * @method $this setCity(string $city)
 * @method $this setCompany(string $company)
 * @method $this setCountry(string $country)
 * @method $this setCustomerCode(string $customerCode)
 * @method $this setCustomerNo(string $customerNo)
 * @method $this setDateOfBirth(string $dateOfBirth)
 * @method $this setEmail(string $email)
 * @method $this setFirstName(string $firstName)
 * @method $this setLastName(string $lastName)
 * @method $this setLang(string $lang)
 * @method $this setPhone(string $phone)
 * @method $this setProfileType(string $profileType)
 * @method $this setState(string $state)
 * @method $this setStreet(string $street)
 * @method $this setStreet2(string $street2)
 * @method $this setZip(string $zip)
 */
class PayeeUpdate extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'city',
            'country',
            'countryCode',
            'createdTime',
            'customerCode',
            'customerNo',
            'dateOfBirth',
            'email',
            'firstName',
            'lastName',
            'mobileNumber',
            'profileType',
            'state',
            'street',
        ));

        $this->addCallable(array(
            'city',
            'country',
            'countryCode',
            'customerCode',
            'customerNo',
            'dateOfBirth',
            'email',
            'firstName',
            'lastName',
            'lang',
            'phone',
            'profileType',
            'state',
            'street',
            'street2',
            'zip',
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
