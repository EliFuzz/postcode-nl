<?php

namespace RestApi\HtttpClient;

use GuzzleHttp\Client;

class HttpClient
{
    private $client;

    public function __construct()
    {
        $this->client = new Client($this->getInitConfig());
    }

    private function getInitConfig(): array
    {
        return [
            'connect_timeout' => 3,
            'timeout'         => 10,
            'http_errors'     => false,
        ];
    }

    public function setConfigs(array $configs): void
    {
        $this->client = new Client(array_merge($this->client->getConfig(), $configs));
    }

    public function doGet($url): array
    {
        $response = $this->client->get($url);

        return [
            'statusCode' => $response->getStatusCode(),
            'body'       => json_decode($response->getBody()->getContents(), true),
        ];
    }
}
