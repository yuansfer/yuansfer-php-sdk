<?php


namespace Yuansfer\Api;

/**
 * Class CustomerAdd
 *
 * @package Yuansfer\Api
 * @author  FENG Hao <flyinghail@msn.com>
 *
 * @method $this setFirstName(string $firstName)
 * @method $this setLastName(string $lastName)
 * @method $this setGroupCode(string $groupCode)
 * @method $this setCustomerCode(string $customerCode)
 * @method $this setStreet(string $street)
 * @method $this setCity(string $city)
 * @method $this setState(string $state)
 * @method $this setCountry(string $country)
 * @method $this setZip(string $zip)
 * @method $this setEmail(string $email)
 * @method $this setPhone(string $phone)
 * @method $this setCompany(string $company)
 */
class CustomerAdd extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'firstName',
            'lastName',
            'groupCode',
            'customerCode',
            'street',
            'city',
            'state',
            'country',
            'zip',
        ));

        $this->addCallable(array(
            'firstName',
            'lastName',
            'groupCode',
            'customerCode',
            'street',
            'city',
            'state',
            'country',
            'zip',
            'email',
            'phone',
            'company',
        ));

        $this->params['groupCode'] = 'HPP';

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'creditpay/v2/customer/add';
    }
}
