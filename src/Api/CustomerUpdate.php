<?php


namespace Yuansfer\Api;

/**
 * Class CustomerUpdate
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 *
 * @method $this setCity(string $city)
 * @method $this setCompany(string $company)
 * @method $this setCountry(string $country)
 * @method $this setCreatedTime(string $createdTime)
 * @method $this setCustomerCode(string $customerCode)
 * @method $this setCustomerNo(string $customerNo)
 * @method $this setDateOfBirth(string $dateOfBirth)
 * @method $this setEmail(string $email)
 * @method $this setFirstName(string $firstName)
 * @method $this setLastName(string $lastName)
 * @method $this setLang(string $lang)
 * @method $this setMobileNumber(string $mobileNumber)
 * @method $this setPhone(string $phone)
 * @method $this setProfileType(string $profileType)
 * @method $this setState(string $state)
 * @method $this setStreet(string $street)
 * @method $this setStreet2(string $street2)
 * @method $this setUpdatedTime(string $updatedTime)
 * @method $this setZip(string $zip)
 */
class CustomerUpdate extends AbstractApi
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
            'city',
            'company',
            'country',
            'countryCode',
            'createdTime',
            'customerCode',
            'customerNo',
            'dateOfBirth',
            'email',
            'firstName',
            'lastName',
            'lang',
            'mobileNumber',
            'phone',
            'profileType',
            'state',
            'street',
            'street2',
            'updatedTime',
            'zip',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'v1/customers/update';
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
