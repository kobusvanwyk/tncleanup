<?php
/**
 * Copyright © 2024 - Code Infinity. All right reserved.
 *
 * @author Justin Bruce <justin@codeinfinity.co.za>
 */

namespace Model\Frontend;

class ConfirmPaymentResponse
{
    public string $customerId;

    public string $error;

    public bool $success;

    public bool $failed;

    public bool $requiresAction;

    public string $paymentIntentClientSecret;

    public string $message;
}