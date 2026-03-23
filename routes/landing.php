<?php

/**
 * Get Privacy Policy page
 */
\Tina4\Get::add("/privacy", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response (\Tina4\renderTemplate("screens/privacy-policy.twig"), HTTP_OK, TEXT_HTML);
});
/**
 * Get Terms and conditions page
 */
\Tina4\Get::add("/tc", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response (\Tina4\renderTemplate("screens/terms-and-conditions.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get Cookies page
 */
\Tina4\Get::add("/cookies", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response (\Tina4\renderTemplate("screens/cookies.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get Terms of Service page
 */
\Tina4\Get::add("/tos", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response (\Tina4\renderTemplate("screens/terms-of-service.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get Terms of Service page
 */
\Tina4\Get::add("/dpa", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response (\Tina4\renderTemplate("screens/dpa.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get FAQ page
 */
\Tina4\Get::add("/faq", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response (\Tina4\renderTemplate("screens/faq.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get Contact Us page
 */
\Tina4\Get::add("/contact-us", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response (\Tina4\renderTemplate("screens/contact-us.twig", ["recaptchaSiteKey" => $_ENV['RECAPTCHA_V3_SITE_KEY']]), HTTP_OK, TEXT_HTML);
});

/**
 * Get Deal Mirror - Our Story page
 */
\Tina4\Get::add("/dealmirror-our-story", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response (\Tina4\renderTemplate("screens/dealmirror-our-story.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get AppSumo Landing Page - Archived/Depreciated
 */
\Tina4\Get::add("/appsumo-dep", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response (\Tina4\renderTemplate("screens/appsumo-dep.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get Agency Test Page - Weird usage for showing clients
 */
\Tina4\Get::add("/ltd-test", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response (\Tina4\renderTemplate("screens/ltd-test.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get Agency Landing Page
 */
\Tina4\Get::add("/agency", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response (\Tina4\renderTemplate("screens/agency.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get Review Management Apps Page
 */
\Tina4\Get::add("/review-management-apps", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response (\Tina4\renderTemplate("screens/review-management-apps.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get Business Page
 */
\Tina4\Get::add("/business", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response(\Tina4\renderTemplate("screens/business.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get Business Meta Page
 */
\Tina4\Get::add("/business-meta", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response(\Tina4\renderTemplate("screens/business-meta.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get Business LinkedIn Page
 */
\Tina4\Get::add("/business-linkedin", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response(\Tina4\renderTemplate("screens/business-linkedin.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get Business Quora Page
 */
\Tina4\Get::add("/business-quora", function (\Tina4\Response $response, \Tina4\Request $request) {
    return $response(\Tina4\renderTemplate("screens/business-quora.twig"), HTTP_OK, TEXT_HTML);
});

/**
 * Get Marketing Agency LTD Page
 */
\Tina4\Get::add("/marketing-agency-ltd", function (\Tina4\Response $response, \Tina4\Request $request) {
    $couponBundlesAgency = (new CampaignBundleLinkView())->select('*', 999)
        ->where('campaign_id = ?', [$_ENV['CAMPAIGN_AGENCY_STANDARD']])
        ->orderBy(['price_incl'])
        ->asObject();

    return $response(
        \Tina4\renderTemplate(
            "screens/marketing-agency-ltd.twig",
            [
                "couponBundles" => $couponBundlesAgency,
                'stripePublicKey' => $_ENV['STRIPE_PUBLISHABLE_KEY']
            ]
        ),
        HTTP_OK,
        TEXT_HTML
    );
});

/**
 * Get Marketing Agency LTD Meta Page
 */
\Tina4\Get::add("/marketing-agency-ltd-meta", function (\Tina4\Response $response, \Tina4\Request $request) {
    $couponBundlesAgency = (new CampaignBundleLinkView())->select('*', 999)
        ->where('campaign_id = ?', [$_ENV['CAMPAIGN_AGENCY_STANDARD']])
        ->orderBy(['price_incl'])
        ->asObject();

    return $response(
        \Tina4\renderTemplate(
            "screens/marketing-agency-ltd-meta.twig",
            [
                "couponBundles" => $couponBundlesAgency,
                'stripePublicKey' => $_ENV['STRIPE_PUBLISHABLE_KEY']
            ]
        ),
        HTTP_OK,
        TEXT_HTML
    );
});

/**
 * Get Marketing Agency LTD LinkedIn Page
 */
\Tina4\Get::add("/marketing-agency-ltd-linkedin", function (\Tina4\Response $response, \Tina4\Request $request) {
    $couponBundlesAgency = (new CampaignBundleLinkView())->select('*', 999)
        ->where('campaign_id = ?', [$_ENV['CAMPAIGN_AGENCY_STANDARD']])
        ->orderBy(['price_incl'])
        ->asObject();

    return $response(
        \Tina4\renderTemplate(
            "screens/marketing-agency-ltd-linkedin.twig",
            [
                "couponBundles" => $couponBundlesAgency,
                'stripePublicKey' => $_ENV['STRIPE_PUBLISHABLE_KEY']
            ]
        ),
        HTTP_OK,
        TEXT_HTML
    );
});

/**
 * Get Marketing Agency LTD Quora Page
 */
\Tina4\Get::add("/marketing-agency-ltd-quora", function (\Tina4\Response $response, \Tina4\Request $request) {
    $couponBundlesAgency = (new CampaignBundleLinkView())->select('*', 999)
        ->where('campaign_id = ?', [$_ENV['CAMPAIGN_AGENCY_STANDARD']])
        ->orderBy(['price_incl'])
        ->asObject();

    return $response(
        \Tina4\renderTemplate(
            "screens/marketing-agency-ltd-quora.twig",
            [
                "couponBundles" => $couponBundlesAgency,
                'stripePublicKey' => $_ENV['STRIPE_PUBLISHABLE_KEY']
            ]
        ),
        HTTP_OK,
        TEXT_HTML
    );
});

/**
 * Get Marketing Agency LTD Free Trial Page
 */
\Tina4\Get::add("/marketing-agency-ltd-free-trial", function (\Tina4\Response $response, \Tina4\Request $request) {
    $couponBundlesAgency = (new CampaignBundleLinkView())->select('*', 999)
        ->where('campaign_id = ?', [$_ENV['CAMPAIGN_AGENCY_STANDARD']])
        ->orderBy(['price_incl'])
        ->asObject();

    return $response(
        \Tina4\renderTemplate(
            "screens/marketing-agency-ltd-free-trial.twig",
            [
                "couponBundles" => $couponBundlesAgency,
                'stripePublicKey' => $_ENV['STRIPE_PUBLISHABLE_KEY']
            ]
        ),
        HTTP_OK,
        TEXT_HTML
    );
});

/**
 * Get KEN MOO page
 */
\Tina4\Get::add("/marketing-agency-ltd-ken-moo", function (\Tina4\Response $response, \Tina4\Request $request) {
    $couponBundlesKenMooFounder = (new CampaignBundleLinkView())->select('*', 999)
        ->where('campaign_id = ?', [$_ENV['CAMPAIGN_KEN_MOO_FOUNDER']])
        ->orderBy(['price_incl'])
        ->asObject();

    $couponBundlesKenMoo90 = (new CampaignBundleLinkView())->select('*', 999)
        ->where('campaign_id = ?', [$_ENV['CAMPAIGN_KEN_MOO_90']])
        ->orderBy(['price_incl'])
        ->asObject();

    /**
     * @var CampaignView $campaignLimit
     */
    $campaignLimit = (new CampaignView())->select('sum(stock_left) as stock_left',1)
        ->where('id in (?,?)',[$_ENV['CAMPAIGN_KEN_MOO_FOUNDER'], $_ENV['CAMPAIGN_KEN_MOO_90']])
        ->asObject()[0];


    return $response (
        \Tina4\renderTemplate(
            "screens/marketing-agency-ltd-ken-moo.twig",
            [
                "couponBundlesFounder" => $couponBundlesKenMooFounder,
                "couponBundles90" => $couponBundlesKenMoo90,
                'stripePublicKey' => $_ENV['STRIPE_PUBLISHABLE_KEY'],
                'stockLeft' => $campaignLimit->stockLeft
            ]
        ),
        HTTP_OK,
        TEXT_HTML
    );
});

/**
 * Get Hunt page
 */
\Tina4\Get::add("/marketing-agency-ltd-hunt", function (\Tina4\Response $response, \Tina4\Request $request) {
    $couponBundlesKenMooFounder = (new CampaignBundleLinkView())->select('*', 999)
        ->where('campaign_id = ?', [$_ENV['CAMPAIGN_HUNT_FOUNDER']])
        ->orderBy(['price_incl'])
        ->asObject();

    $couponBundlesKenMoo90 = (new CampaignBundleLinkView())->select('*', 999)
        ->where('campaign_id = ?', [$_ENV['CAMPAIGN_HUNT_90']])
        ->orderBy(['price_incl'])
        ->asObject();

    /**
     * @var CampaignView $campaignLimit
     */
    $campaignLimit = (new CampaignView())->select('sum(stock_left) as stock_left',1)
        ->where('id in (?,?)',[$_ENV['CAMPAIGN_HUNT_FOUNDER'], $_ENV['CAMPAIGN_HUNT_90']])
        ->asObject()[0];


    return $response (
        \Tina4\renderTemplate(
            "screens/marketing-agency-ltd-hunt.twig",
            [
                "couponBundlesFounder" => $couponBundlesKenMooFounder,
                "couponBundles90" => $couponBundlesKenMoo90,
                'stripePublicKey' => $_ENV['STRIPE_PUBLISHABLE_KEY'],
                'stockLeft' => $campaignLimit->stockLeft
            ]
        ),
        HTTP_OK,
        TEXT_HTML
    );
});
