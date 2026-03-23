<?php
/**
 * Copyright © 2024 - Code Infinity. All right reserved.
 *
 * @author Justin Bruce <justin@codeinfinity.co.za>
 * @link https://stripe.com/docs/api/payment_intents/create
 */

namespace app\helper;

use Model\Frontend\ConfirmPaymentResponse;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

class Stripe
{
    /**
     * @var StripeClient
     */
    protected StripeClient $stripeClient;

    /**
     *
     */
    public function __construct()
    {
        $this->stripeClient = new StripeClient($_ENV["STRIPE_API_KEY"]);
    }

    /**
     * @param string $email
     * @return false|string
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function checkCustomerExist(string $email)
    {
        $customers = $this->stripeClient->customers->all([
            'email' => $email
        ]);

        return count($customers->data) >= 1 ? $customers->data[0]->id : false;
    }

    /**
     * @param string $email
     * @param string $name
     * @param string|null $description
     * @return string
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createCustomer(string $email, string $name, ?string $description = null)
    {
        $customer = $this->stripeClient->customers->create([
            'email' => $email,
            'name' => $name,
            'description' => $description
        ]);

        return $customer->id;
    }

    /**
     * @param string $description Description of Customer
     * @param string $email Organization Contact Email
     * @param string $fullName Organization Contact Full Name
     * @return string
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getOrCreateCustomer(string $description, string $email, string $fullName)
    {
        $customerId = $this->checkCustomerExist($email);

        if (!empty($customerId)) {
            return $customerId;
        }

        return $this->createCustomer($email, $fullName, $description);
    }

    /**
     * @param string $stripeId
     * @param string $email
     * @param string $name
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function updateCustomer(string $stripeId, string $email, string $name)
    {
        $this->stripeClient->customers->update($stripeId,
            [
                'name' => $name,
                'email' => $email
            ]);
    }

    /**
     * @param string $name
     * @return string
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function checkProductExist(string $name)
    {
        $stripeId = 'false';

        $products = $this->stripeClient->products->all([
            'limit' => 99999
        ]);

        if (count($products->data) >= 1) {
            foreach ($products->data as $product) {
                if ($product->name == $name) {
                    $stripeId = $product->id;
                    break;
                }
            }
        }

        return $stripeId;
    }

    /**
     * @param string $name
     * @return string
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createProduct(string $name)
    {
        $stripeProduct = $this->stripeClient->products->create([
            'name' => $name
        ]);

        return $stripeProduct->id;
    }

    /**
     * @param string $prodStripeId
     * @return string
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function checkProductPriceExists(string $prodStripeId)
    {

        $prices = $this->stripeClient->prices->all([
            'product' => $prodStripeId
        ]);

        return (count($prices->data) >= 1 ? $prices->data[0]->id : 'false');
    }

    /**
     * @param string $prodStripeId
     * @param float $costDollars
     * @param int $isRecurring
     * @param int $subscriptionMonths
     * @return string
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createProductPrice(string $prodStripeId, float $costDollars, int $isRecurring, int $subscriptionMonths = 1)
    {
        $formatPrice = str_replace(',', '', str_replace('.', '', $costDollars));

        if ($isRecurring == 1) {
            $stripePrice = $this->stripeClient->prices->create([
                'unit_amount' => $formatPrice,
                'currency' => 'usd',
                'recurring' => [
                    'interval' => 'month',
                    'interval_count' => $subscriptionMonths
                ],
                'product' => $prodStripeId,
            ]);
        } else {
            $stripePrice = $this->stripeClient->prices->create([
                'unit_amount' => $formatPrice,
                'currency' => 'usd',
                'product' => $prodStripeId,
            ]);
        }

        return $stripePrice->id;
    }

    /**
     * @param string $customerId
     * @param string|null $last4
     * @return false|string|null
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function checkCustomerHavePaymentMethod(string $customerId, string $last4 = null)
    {
        $paymentMethodId = false;
        $paymentMethods = $this->stripeClient->customers->allPaymentMethods(
            $customerId,
            ['type' => 'card']
        );

        if (count($paymentMethods->data) >= 1) {
            if (!empty($last4)) {
                if (strlen($last4) > 4) {
                    $last4 = substr($last4, -4);
                }

                foreach ($paymentMethods->data as $paymentMethod) {
                    if ($paymentMethod->card->last4 == $last4) {
                        $paymentMethodId = $paymentMethod->id;
                        break;
                    }
                }
            } else {
                $paymentMethodId = $paymentMethods->data[0]->id;
            }
        }

        return $paymentMethodId;
    }

    /**
     * @param string $paymentMethodId
     * @return \Stripe\PaymentMethod
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getPaymentMethod(string $paymentMethodId)
    {
        return $this->stripeClient->paymentMethods->retrieve(
            $paymentMethodId,
            []
        );
    }

    /**
     * @param string $cardNo
     * @param string $expMonth
     * @param string $expYear
     * @param string $cvc
     * @return string
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createPaymentMethod(string $cardNo, string $expMonth, string $expYear, string $cvc)
    {
        $paymentMethod = $this->stripeClient->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'number' => $cardNo,
                'exp_month' => $expMonth,
                'exp_year' => $expYear,
                'cvc' => $cvc,
            ]
        ]);

        return $paymentMethod->id;
    }

    /**
     * @param string $customerId
     * @param string $paymentMethodId
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function attachCustomerPaymentMethod(string $customerId, string $paymentMethodId)
    {
        $this->stripeClient->paymentMethods->attach(
            $paymentMethodId,
            ['customer' => $customerId]
        );
    }

    /**
     * @param string $customerId
     * @param string $method
     * @return array
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createSetupIntent(string $customerId, string $method)
    {
        $setupIntent = $this->stripeClient->setupIntents->create([
            'customer' => $customerId,
            'payment_method_types' => [$method],
        ]);

        return ['id' => $setupIntent->id, 'clientSecret' => $setupIntent->client_secret];
    }

    /**
     * @param string $paymentIntentId
     * @param array $data
     * @return PaymentIntent
     * @throws ApiErrorException
     */
    public function updatePaymentIntent(string $paymentIntentId, array $data): PaymentIntent
    {
        return $this->stripeClient->paymentIntents->update($paymentIntentId, $data);
    }

    /**
     * @param string $customerId
     * @param string|null $paymentMethodId
     * @param float $amount
     * @return ConfirmPaymentResponse
     */
    public function pay(string $customerId, ?string $paymentMethodId, float $amount): ConfirmPaymentResponse
    {
        $response = new ConfirmPaymentResponse();
        $response->customerId = $customerId;

        $service = $this->stripeClient->paymentIntents;

        if (!isset($paymentMethodId)) {
            $response->error = "No payment method is available";

            return $response;
        }

        try {
            $paymentIntent = $service->create([
                'amount' => $this->getUnitAmount($amount),
                'currency' => "usd",
                'customer' => $customerId,
                'payment_method' => $paymentMethodId,
                'confirm' => true,
                'off_session' => true
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response->error = $e->getError();

            return $response;
        }

        return $this->generatePaymentResponse($paymentIntent, $response);
    }

    /**
     * @param PaymentIntent $intent
     * @param ConfirmPaymentResponse $response
     * @return ConfirmPaymentResponse
     */
    private function generatePaymentResponse(PaymentIntent $intent, ConfirmPaymentResponse $response)
    {
        if ($intent->status == "requires_action" &&
            $intent->next_action->type == "use_stripe_sdk") {
            // Tell the client to handle the action
            $response->requiresAction = true;
            $response->paymentIntentClientSecret = $intent->client_secret;
        } else if ($intent->status == "succeeded") {
            // The payment didn't need any additional actions and completed!
            // Handle post-payment fulfillment
            $response->success = true;
        } else if ($intent->status == "requires_payment_method") {
            $response->failed = true;
        } else {
            // Invalid status
            $response->error = "Invalid PaymentIntent status";
        }

        return $response;
    }

    /**
     * @param string $customerId
     * @param string $priceId
     * @return \Stripe\InvoiceItem
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createInvoiceItem($customerId, $priceId)
    {
        return $this->stripeClient->invoiceItems->create([
            'customer' => $customerId,
            'price' => $priceId,
        ]);
    }

    /**
     * @param string $customerId
     * @return \Stripe\Invoice
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createCustomerInvoice($customerId)
    {
        return $this->stripeClient->invoices->create([
            'customer' => $customerId,
        ]);
    }

    /**
     * @param string $invoiceId
     * @return \Stripe\Invoice
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function finalizeInvoice($invoiceId)
    {
        return $this->stripeClient->invoices->finalizeInvoice(
            $invoiceId,
            []
        );
    }

    /**
     * @param string $invoiceId
     * @param string $paymentMethodId
     * @return \Stripe\Invoice
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function customerPayInvoice($invoiceId, $paymentMethodId)
    {
        return $this->stripeClient->invoices->pay(
            $invoiceId,
            ['payment_method' => $paymentMethodId]
        );
    }

    /**
     * @param string $priceId
     * @param string $productId
     * @param string $description
     * @param int|null $campaignId
     * @return string
     * @throws ApiErrorException
     */
    public function createCheckoutSession(string $priceId, string $productId, string $description, ?int $campaignId): string
    {
        $checkoutSession = $this->stripeClient->checkout->sessions->create([
            'ui_mode' => 'embedded',
            'line_items' => [
                [
                    'price' => $priceId,
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'allow_promotion_codes' => true,
            'return_url' => $_ENV['BASE_URL'] . '/payment-confirmation?session_id={CHECKOUT_SESSION_ID}',
            'metadata' => [
                'productId' => $productId,
                'description' => $description,
                'campaignId' => $campaignId
            ]
        ]);

        return $checkoutSession->client_secret ?? throw new \Exception('Failed to create Checkout Session');
    }

    /**
     * @param string $sessionId
     * @return \Stripe\Checkout\Session
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getCheckoutSession(string $sessionId): \Stripe\Checkout\Session
    {
        return $this->stripeClient->checkout->sessions->retrieve($sessionId);
    }

    /**
     * @param array $params
     * @return \Stripe\Collection
     * @throws ApiErrorException
     */
    public function getCheckoutSessionList(array $params): \Stripe\Collection
    {
        return $this->stripeClient->checkout->sessions->all($params);
    }

    /**
     * @param string $sessionId
     * @return \Stripe\Collection
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getCheckoutLineItems(string $sessionId): \Stripe\Collection
    {
        return $this->stripeClient->checkout->sessions->allLineItems($sessionId);
    }

    /**
     * @param string $sessionId
     * @return \Stripe\Checkout\Session
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function expireCheckoutSession(string $sessionId): \Stripe\Checkout\Session
    {
        return $this->stripeClient->checkout->sessions->expire($sessionId);
    }

    /**
     * @param float $amount
     * @return int
     */
    private function getUnitAmount(float $amount): int
    {
        return (int)($amount * 100);
    }
}