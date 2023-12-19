<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleBooksApiService
{
    public function __construct(
        private readonly HttpClientInterface $httpClient
    )
    {
    }


    public function get($id)
    {
        return $this->api('GET', "https://www.googleapis.com/books/v1/volumes/{$id}");
    }


    public function search(string $search): array
    {
        if (strlen($search) < 3) {
            return [];
        }
        return $this->api('GET', 'https://www.googleapis.com/books/v1/volumes', [
            "query" => [
                "q" => $search
            ]
        ]);
    }


    public function api (string $method, string $url, array $params = []): array
    {
        return $this->httpClient->request($method, $url, $params)->toArray();
    }
}
