<?php
/**
 * Chapa Helper for Ogge Travel
 * Handles direct cURL requests to Chapa API
 */

class ChapaHelper {
    private $secretKey;
    private $baseUrl;

    public function __construct($config) {
        $this->secretKey = $config['chapa_secret_key'];
        $this->baseUrl = $config['base_url'];
    }

    /**
     * Initialize a Chapa Transaction
     */
    public function initializeTransaction($data) {
        $url = "https://api.chapa.co/v1/transaction/initialize";
        
        $params = [
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'ETB',
            'email' => $data['email'],
            'first_name' => $data['first_name'] ?? 'Guest',
            'last_name' => $data['last_name'] ?? 'User',
            'tx_ref' => $data['tx_ref'],
            'callback_url' => $this->baseUrl . "/pages/pay.php?chapa_callback=1&tx_ref=" . $data['tx_ref'],
            'return_url' => $this->baseUrl . "/pages/pay.php?booking_id=" . $data['booking_id'] . "&chapa_success=1&tx_ref=" . $data['tx_ref']
        ];

        return $this->chapaRequest($url, $params);
    }

    /**
     * Verify a Chapa Transaction
     */
    public function verifyTransaction($txRef) {
        $url = "https://api.chapa.co/v1/transaction/verify/" . $txRef;
        return $this->chapaRequest($url, [], 'GET');
    }

    /**
     * General Chapa cURL request
     */
    private function chapaRequest($url, $params = [], $method = 'POST') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $this->secretKey,
            "Content-Type: application/json"
        ]);
        
        // Skip SSL verification for local development compatibility
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log('Chapa cURL Error: ' . curl_error($ch));
            return ['status' => 'error', 'message' => curl_error($ch)];
        }
        curl_close($ch);
        
        error_log('Chapa Raw Response: ' . $result);

        return json_decode($result, true);
    }
}
