<?php
/**
 * Copyright © 2024 - Code Infinity. All right reserved.
 *
 * @author Justin Bruce <justin@codeinfinity.co.za>
 */

/**
 * Stripe webhook to handle successful payment intents
 */
\Tina4\Post::add("/webhook/stripe", function (\Tina4\Response $response, \Tina4\Request $request) {
    ignore_user_abort(true);
    try {
        (new \app\helper\Payment())->handleWebhookResponse();

        return $response ('', HTTP_OK, TEXT_HTML);
    } catch (Exception $exception) {
        return $response ($exception->getMessage(), HTTP_BAD_REQUEST);
    }
});