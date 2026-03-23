<?php
/**
 * Copyright © 2024 - Code Infinity. All right reserved.
 *
 * @author Justin Bruce <justin@codeinfinity.co.za>
 * @link https://mailchimp.com/developer/transactional/api/allowlists/
 */

namespace App\Helper;


use GuzzleHttp\Exception\RequestException;
use MailchimpTransactional\ApiClient;

class Email
{

    /**
     * @param array $toArray
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function sendEmailHTML(array $toArray, array $data): bool
    {
        try {
            $mailchimp = new ApiClient();
            $mailchimp->setApiKey($_ENV['MANDRILL_API_KEY']);

            $content = \Tina4\renderTemplate("email/contact-us.twig", ["sender" => $data]);

            $message = (object)[
                'html' => $content,
                'subject' => 'RMS Contact Us Form Submission',
                'from_email' => 'no-reply@ratemyservice.io',
                'from_name' => 'RMS Contact Us',
                'to' => $toArray,
                'preserve_recipients' => false
            ];

            $response = $mailchimp->messages->send(['message' => $message]);

            if (isset($response[0]->status) && $response[0]->status == 'sent') {
                return true;
            } else {
                throw new \Exception($response[0]->reject_reason ?? 'Failed to send email');
            }
        } catch (\Exception|RequestException) {
            throw new \Exception('Failed to send email');
        }
    }


    /**
     * @param array $toArray
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function sendWhiteLabelEmailHTML(array $toArray, array $data): bool
    {
        try {
            $mailchimp = new ApiClient();
            $mailchimp->setApiKey($_ENV['MANDRILL_API_KEY']);

            $content = \Tina4\renderTemplate("email/white-label-application.twig", ["sender" => $data]);

            $message = (object)[
                'html' => $content,
                'subject' => 'RMS White-Label Application Form Submission',
                'from_email' => 'no-reply@ratemyservice.io',
                'from_name' => 'RMS White Label Application',
                'to' => $toArray,
                'preserve_recipients' => false
            ];

            $response = $mailchimp->messages->send(['message' => $message]);

            if (isset($response[0]->status) && $response[0]->status == 'sent') {
                return true;
            } else {
                throw new \Exception($response[0]->reject_reason ?? 'Failed to send email');
            }
        } catch (\Exception|RequestException) {
            throw new \Exception('Failed to send email');
        }
    }


    /**
     * @param array $toArray
     * @param array $data
     * @return true
     * @throws \Exception
     */
    public function sendCouponBundleEmail(array $toArray, array $data)
    {
        try {
            $mailchimp = new ApiClient();
            $mailchimp->setApiKey($_ENV['MANDRILL_API_KEY']);

            $content = \Tina4\renderTemplate("email/coupon-codes.twig", $data);

            $message = (object)[
                'html' => $content,
                'subject' => 'RateMyService - Agency Bundle - Next Steps! ',
                'from_email' => 'support@ratemyservice.io',
                'from_name' => 'RateMyService',
                'to' => $toArray,
                'preserve_recipients' => false
            ];

            $response = $mailchimp->messages->send(['message' => $message]);

            if (isset($response[0]->status) && $response[0]->status == 'sent') {
                return true;
            } else {
                throw new \Exception($response[0]->reject_reason ?? 'Failed to send email');
            }
        } catch (\Exception|RequestException) {
            throw new \Exception('Failed to send email');
        }
    }
}