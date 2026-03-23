<?php

use App\Helper\Email;

/**
 * POST request from White-Label Application page - send email
 */
\Tina4\Post::add("/api/white-label-application/send-email", function(\Tina4\Response $response, \Tina4\Request $request)
{
    if ((new \App\Helper\CaptchaHelper())->checkCaptcha($request)) {
        $sender = [];
        $sender["dashboardUrl"] = $request->params["dashboardUrl"];
        $sender["companyName"] = $request->params["companyName"];
        $sender["email"] = $request->params["email"];
        $sender["codes"] = $request->params["codes"];
        $sender["domainName"] = $request->params["domainName"];
        $sender["subdomain"] = $request->params["subdomain"];
        $sender["fromEmail"] = $request->params["fromEmail"];
        $sender["time"] = date("Y-m-d H:i:s");

        $toArray[] = (object)[
            'email' => $_ENV['WHITE_LABEL_APPLICATION_EMAIL'],
            'name' => 'Ricky',
            'type' => 'to'
        ];

        try {
            (new Email())->sendWhiteLabelEmailHTML($toArray, $sender);
            \Tina4\redirect("/white-label-application?success=true");
        } catch (Exception $exception) {
            \Tina4\redirect("/white-label-application?success=false");
        }
    } else {
        \Tina4\redirect("/white-label-application?captcha=true");
    }
});
