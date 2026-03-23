<?php

namespace app\helper;

use model\request\CouponBundlePayment;
use Stripe\Charge;
use Stripe\Checkout\Session;
use Stripe\Event;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;

use function Tina4\renderTemplate;

class Payment
{
    const BUNDLE_PAYMENT_DESCRIPTION = "";

    /**
     * @var Stripe
     */
    protected Stripe $stripeHelper;

    /**
     * @var Email
     */
    protected Email $emailHelper;

    public function __construct()
    {
        $this->stripeHelper = new Stripe();
        $this->emailHelper = new Email();
    }

    /**
     * @param int $couponBundleId
     * @param string $description
     * @param int|null $campaignId
     * @return string
     * @throws \Exception
     */
    public function startPaymentProcess(int $couponBundleId, string $description = "", ?int $campaignId = null): string
    {
        $productBundle = new \CouponBundle();

        if ($productBundle->load("id = ? and is_active = 1", [$couponBundleId])) {
            try {
                return $this->stripeHelper->createCheckoutSession($productBundle->priceStripeId, $productBundle->stripeId, $description, $campaignId);
            } catch (\Exception|ApiErrorException $exception) {
                throw new \Exception("Something went wrong. Please try again later.");
            }
        }

        throw new \Exception("Product Bundle does not exist");
    }

    /**
     * @param string $sessionId
     * @return bool
     * @throws \Exception
     */
    public function handlePaymentConfirmation(string $sessionId): bool
    {
        try {
            $checkoutSession = $this->stripeHelper->getCheckoutSession($sessionId);

            if (in_array($checkoutSession->payment_status, ['paid', 'processing'])) {
                return true;
            }
        } catch (\Exception|ApiErrorException $exception) {
            throw new \Exception("Error processing checkout!");
        }

        throw new \Exception("Checkout failed!");
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function handleWebhookResponse(): bool
    {
        try {
            /**
             * @var Event $event
             */
            $event = json_decode(@file_get_contents('php://input'));

            if ($event->type == 'payment_intent.succeeded') {
                /**
                 * @var PaymentIntent $paymentIntent
                 */
                $paymentIntent = $event->data->object;
                $campaignId = null;

                if ($paymentIntent->status == 'succeeded') {
                    $couponBundleCodes = (new \CouponBundleCode())->select('*', 1)->where(
                        'payment_intent_id = ?',
                        [$paymentIntent->id]
                    )->asArray();

                    if (!empty($couponBundleCodes)) {
                        throw new \Exception("Payment Session already processed");
                    }

                    $checkoutSessions = $this->stripeHelper->getCheckoutSessionList(['payment_intent' => $paymentIntent->id]);

                    /**
                     * @var Session $checkoutSession
                     */
                    if(empty($checkoutSessions->data)) {
                        //Return true as false positive for non-website related purchases
                        return true;
                    }

                    $checkoutSession = $checkoutSessions->data[0];

                    // Update payment intent description
                    if (!empty($checkoutSession->metadata->description)) {
                        $this->stripeHelper->updatePaymentIntent($paymentIntent->id, ['description' => $checkoutSession->metadata->description]);
                    }

                    if (!empty($checkoutSession->metadata->campaignId)) {
                        $campaignId = $checkoutSession->metadata->campaignId;
                    }

                    /**
                     * @var Charge $charge
                     */
                    $charge = $paymentIntent->charges->data[0];

                    if (!empty($checkoutSession->metadata->productId) && $charge->paid) {
                        $couponBundle = new \CouponBundle();

                        if ($couponBundle->load('stripe_id = ?', [$checkoutSession->metadata->productId])) {
                            if (!empty($charge->billing_details->email)) {
                                $toEmail = $charge->billing_details->email;
                            } else {
                                throw new \Exception("Missing email");
                            }

                            if (!empty($charge->billing_details->name)) {
                                $toName = $charge->billing_details->name;
                            } else {
                                $toName = $toEmail;
                            }

                            $generatedCoupons = $this->generateCouponCodes($couponBundle, $paymentIntent->id, $campaignId);

                            $toArray[] = (object)[
                                'email' => $toEmail,
                                'name' => $toName,
                                'type' => 'to'
                            ];

                            $this->emailHelper->sendCouponBundleEmail(
                                $toArray,
                                [
                                    'coupons' => $generatedCoupons,
                                    'email' => $toEmail,
                                    'bundleName' => $couponBundle->name
                                ]
                            );

                            return true;
                        }
                    }
                }
            }
        } catch (\Exception|\UnexpectedValueException|ApiErrorException $e) {
            throw new \Exception($e->getMessage());
        }

        throw new \Exception('Failed to complete processing checkout!');
    }

    /**
     * @param \CouponBundle $productBundle
     * @param string|null $paymentIntentId
     * @param int|null $campaignId
     * @return array
     * @throws \Exception
     */
    private function generateCouponCodes(\CouponBundle $productBundle, ?string $paymentIntentId = null, ?int $campaignId = null): array
    {
        $currentCount = 0;
        $couponCollection = [];

        do {
            $code = $this->getNewCouponCode($productBundle->characterLength);

            if (!empty($productBundle->prefix)) {
                $code = $productBundle->prefix . '-' . $code;
            }

            $couponCheck = new \CouponCode();

            if ($couponCheck->load("code = ?", [$code])) {
                continue;
            } else {
                $couponCode = new \CouponCode();
                $couponCode->initiative = $productBundle->initiative;
                $couponCode->maxUses = $productBundle->maxUses;
                $couponCode->discount = $productBundle->discountId;
                $couponCode->duration = $productBundle->duration;
                $couponCode->subscriptionLevel = $productBundle->subscriptionLevelId;
                $couponCode->code = $code;

                if ($couponCode->save()) {
                    $couponBundleCode = new \CouponBundleCode();
                    $couponBundleCode->couponId = $couponCode->id;
                    $couponBundleCode->couponBundleId = $productBundle->id;
                    $couponBundleCode->paymentIntentId = $paymentIntentId;
                    $couponBundleCode->campaignId = $campaignId;
                    $couponBundleCode->save();
                }

                $couponCollection[] = $code;

                $currentCount++;
            }
        } while ($currentCount < $productBundle->amount);

        return $couponCollection;
    }

    /**
     * @param int $length
     * @return string
     */
    private function getNewCouponCode(int $length): string
    {
        return substr(str_shuffle(str_repeat($x = 'BCDFGHJKLMNPQRSTVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
}