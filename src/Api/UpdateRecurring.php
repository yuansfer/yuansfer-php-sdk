<?php

namespace Yuansfer\Api;

use Yuansfer\Exception\InvalidParamException;

/**
 * Class UpdateRecurring
 *
 * @package Yuansfer\Api
 * @author  Feng Hao <flyinghail@msn.com>
 * @see     https://docs.yuansfer.com/#update_recurring
 *
 * @method $this setScheduleNo(string $scheduleNo)
 */
class UpdateRecurring extends AbstractApi
{
    public function __construct($yuansfer)
    {
        $this->addRequired(array(
            'scheduleNo',
        ));

        $this->addCallabe(array(
            'scheduleNo',
        ));

        parent::__construct($yuansfer);
    }

    protected function getPath()
    {
        return 'creditpay:update-recurring';
    }

    /**
     * @param int $paymentCount
     *
     * @return $this
     */
    public function setPaymentCount($paymentCount)
    {
        $this->params['paymentCount'] = (int) $paymentCount;

        return $this;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $status = \strtoupper($status);

        if ($status !== 'CANCELLED') {
            throw new InvalidParamException('The param `status` is invalid in update-recurring');
        }

        $this->params['status'] = $status;

        return $this;
    }
}
