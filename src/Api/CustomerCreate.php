<?php


namespace Yuansfer\Api;

/**
 * Class CustomerCreate
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 *
 * @method $this setZip(string $zip)
 * @method $this setFirstName(string $firstName)
 * @method $this setLastName(string $lastName)
 * @method $this setCustomerCode(string $customerCode)
 * @method $this setEmail(string $email)
 * @method $this setCountry(string $country)
 * @method $this setCity(string $city)
 * @method $this setDateOfBirth(string $dateOfBirth)
 * @method $this setPhone(string $phone)
 * @method $this setStreet(string $street)
 * @method $this setStreet2(string $street2)
 * @method $this setState(string $state)
 * @method $this setLang(string $lang)
 * @method $this setProfileType(string $profileType)
 * @method $this setCompany(string $company)
 * @method $this setMobileNumber(string $mobileNumber)
 */
class CustomerCreate extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'firstName',
            'lastName',
            'email',
            'countryCode',
        ));

        $this->addCallable(array(
            'zip',
            'firstName',
            'lastName',
            'customerCode',
            'email',
            'country',
            'city',
            'dateOfBirth',
            'phone',
            'countryCode',
            'street',
            'street2',
            'state',
            'lang',
            'profileType',
            'company',
            'mobileNumber',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'v1/customers/create';
    }

    /**
     * @param string $countryCode
     * @return $this
     */
    public function setCountryCode($countryCode)
    {
        $this->setParams('countryCode', $countryCode);

        if ($countryCode === 'US') {
            $this->addRequired(array(
                'state',
            ));
        } else {
            $this->removeRequired(array(
                'state',
            ));
        }

        return $this;
    }
}
