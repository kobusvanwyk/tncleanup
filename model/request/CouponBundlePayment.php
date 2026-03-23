<?php

namespace model\request;

class CouponBundlePayment
{
    /**
     * @var string
     */
    public string $fullName;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $cardNo;

    /**
     * @var string
     */
    public string $expiryMonth;

    /**
     * @var string
     */
    public string $expiryYear;

    /**
     * @var string
     */
    public string $cvv;

    /**
     * @param array $requestParams
     */
    public function __construct(array $requestParams)
    {
        $this->fullName = ''/*$requestParams['firstName'] . ' ' . $requestParams['lastName']*/;
        $this->email = $requestParams['email'];
        $this->cardNo = $requestParams['cardNumber'];
        $this->expiryMonth = $requestParams['expiryMonth'];
        $this->expiryYear = $requestParams['expiryYear'];
        $this->cvv = $requestParams['cardCode'];
    }
}