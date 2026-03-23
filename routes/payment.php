<?php
/**
 * Copyright © 2024 - Code Infinity. All right reserved.
 *
 * @author Justin Bruce <justin@codeinfinity.co.za>
 */

\Tina4\Get::add("/purchase/coupon-bundle/form", function (\Tina4\Response $response, \Tina4\Request $request) {
    try {
        return $response(\Tina4\renderTemplate(
            "/forms/stripe-payment.twig",
            ['clientSecret' => (new \app\helper\Payment())->startPaymentProcess((int)$request->params['bundleId'], $request->params['pageUrl'], (int)$request->params['campaignId'] ?? null)]));
    } catch (Exception $exception) {
        return $response(
            \Tina4\renderTemplate(
                "components/modalFormNotification.twig",
                [
                    "title" => "Payment Error",
                    "content" => \Tina4\renderTemplate("/forms/payment-error.twig")
                ]
            )
        );
    }
});

/**
 * Manually confirm payments using stripe session_id
 */
\Tina4\Get::add("/payment-confirmation", function (\Tina4\Response $response, \Tina4\Request $request) {
    try {
        if(empty($request->params['session_id'])) {
            throw new Exception("Session required");
        }

        (new \app\helper\Payment())->handlePaymentConfirmation($request->params['session_id']);

        return $response (\Tina4\renderTemplate("screens/payment-success.twig"), HTTP_OK, TEXT_HTML);
    } catch (Exception $exception) {
        return $response (\Tina4\renderTemplate("screens/payment-failure.twig"), HTTP_OK, TEXT_HTML);
    }
});