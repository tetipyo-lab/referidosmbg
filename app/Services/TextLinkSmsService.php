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

    public function sendSms($to, $message,$sim_id ="")
    {
        try {
            $dataSend = [
                'phone_number' => $to,
                'text' => $message,
            ];
            if(!empty($sim_id)){
                $dataSend["sim_card_id"] = $sim_id;
            }
            $response = $this->client->post($this->apiUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer ".$this->apiKey,
                ],
                'body' => json_encode($dataSend),
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
