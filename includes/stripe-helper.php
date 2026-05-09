<?php
/**
 * Stripe Helper for Ogge Travel
 * Handles direct cURL requests to Stripe API without requiring Composer
 */

class StripeHelper {
    private $secretKey;
    private $baseUrl;

    public function __construct($config) {
        $this->secretKey = $config['stripe_secret_key'];
        $this->baseUrl = $config['base_url'];
    }

    /**
     * Create a Stripe Checkout Session
     */
    public function createCheckoutSession($bookingId, $amount, $currency, $productName) {
        $url = "https://api.stripe.com/v1/checkout/sessions";
        
        $params = [
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => strtolower($currency),
                    'unit_amount' => $amount * 100, // Stripe expects cents
                    'product_data' => [
                        'name' => $productName,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->baseUrl . "/pages/pay.php?booking_id=$bookingId&stripe_success=1&session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => $this->baseUrl . "/pages/pay.php?booking_id=$bookingId&stripe_cancel=1",
            'client_reference_id' => $bookingId,
            'metadata' => [
                'booking_id' => $bookingId
            ]
        ];

        return $this->stripeRequest($url, $params);
    }

    /**
     * Verify a Checkout Session
     */
    public function getSession($sessionId) {
        $url = "https://api.stripe.com/v1/checkout/sessions/" . $sessionId;
        return $this->stripeRequest($url, [], 'GET');
    }

    /**
     * General Stripe cURL request
     */
    private function stripeRequest($url, $params = [], $method = 'POST') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->secretKey . ':');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return ['error' => curl_error($ch)];
        }
        curl_close($ch);

        return json_decode($result, true);
    }
}
