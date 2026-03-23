<?php

use App\Helper\CaptchaHelper;
use App\Helper\Email;
use Tina4\Post;
use Tina4\Request;
use Tina4\Response;

use function Tina4\redirect;

/**
 * POST request from Contact Us page - send email
 */
Post::add("/api/contact-us/send-email", function(Response $response, Request $request)
{
    if((new CaptchaHelper())->checkCaptcha($request)) {
        $sender = [];
        $sender["name"] = $request->params["name"];
        $sender["companyname"] = $request->params["companyname"];
        $sender["email"] = $request->params["email"];
        $sender["companytype"] = $request->params["companytype"];
        $sender["referral"] = $request->params["referral"];
        $sender["subject"] = $request->params["subject"];
        $sender["message"] = $request->params["message"];
        $sender["time"] = date("Y-m-d H:i:s");

        $toArray[] = (object)[
            'email' => $_ENV['CONTACT_US_EMAIL'],
            'name' => 'Ricky',
            'type' => 'to'
        ];

        try {
            (new Email())->sendEmailHTML($toArray, $sender);
            redirect("/contact-us?success=true");
        } catch (Exception $exception) {
            redirect("/contact-us?success=false");
        }
    } else {
        redirect("/contact-us?captcha=true");
    }
});
