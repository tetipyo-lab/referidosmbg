<?php

namespace App\Services;

use GuzzleHttp\Client;

class TextLinkSmsService
{
    protected $client;
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = env('TEXTLINKSMS_API_URL');
        $this->apiKey = env('TEXTLINKSMS_API_KEY');
    }

    public function sendSms($to, $message)
    {
        try {
            $response = $this->client->post($this->apiUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer ".$this->apiKey,
                ],
                'body' => json_encode([
                    'phone_number' => $to,
                    'text' => $message,
                ]),
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
