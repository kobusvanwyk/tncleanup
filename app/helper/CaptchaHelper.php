<?php
/**
 * Copyright © 2022 - Code Infinity. All right reserved.
 *
 * @author Justin Bruce <justin@codeinfinity.co.za>
 * @link https://stripe.com/docs/api/payment_intents/create
 */

namespace App\Helper;


class CaptchaHelper
{
    public function checkCaptcha($request)
    {
        $token = $request->params["token"];
        $action = $request->params['action'];
        if(!$token){
            echo '<h2>Please check the captcha form.</h2>';
            exit;
        }

        // post request to server
        $data = array('secret' => $_ENV['RECAPTCHA_V3_SECRET_KEY'], 'response' => $token, 'remoteip' => $_SERVER['REMOTE_ADDR']);
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $captchaResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        $responseKeys = json_decode($captchaResponse,true);

        if($responseKeys["success"]  && $responseKeys["action"] == $action && $responseKeys["score"] >= 0.5) {
            return true;
        } else {
            return false;
        }
    }
}