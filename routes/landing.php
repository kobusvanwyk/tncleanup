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
