<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class LinkeToService
{
    protected $client;
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('LINKE_API_URL'); // URL del endpoint
        $this->apiKey = env('LINKE_API_KEY'); // Clave de API configurada en el archivo de servicios

        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer ".$this->apiKey, // Token de autorización
            ],
        ]);
    }

    /**
     * Crear un enlace corto.
     *
     * @param string $url URL a acortar.
     * @param string $title Título del enlace.
     * @return array Respuesta de la API.
     * @throws \Exception Si ocurre un error en la solicitud.
     */
    public function createShortLink(string $url, string $title): array
    {
        try {
            $response = $this->client->post($this->apiUrl."/shorts/add", [
                'json' => [
                    'url'   => $url,
                    'title' => $title,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Manejo de errores en la solicitud
            $errorMessage = $e->hasResponse()
                ? $e->getResponse()->getBody()->getContents()
                : $e->getMessage();

            throw new \Exception("Error al crear el enlace: $errorMessage");
        }
    }
}
