<?php

namespace App\Fabric\Interfaces;

use Illuminate\Support\Facades\Http;

class OmdbApi implements MovieSearch
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('fabric.fabricApiUrl');
        $this->apiKey = config('fabric.fabricApiKey');
    }

    public function search(string $searchString): array
    {
        try {
            $response = Http::timeout(30)->get(
                $this->baseUrl,
                [
                    'apiKey' => $this->apiKey,
                    's' => $searchString
                ]
            );

            $response->throw();

            $results = $response->json();
            if (isset($results['Error'])) {
                return [
                    'errors' => [ $results['Error'] ]
                ];
            }

            return $results['Search'];
        } catch (\Exception $e) {
            return [
                'errors' => ['Cannot retrieve data.', $e->getMessage()],
                'code' => $e->getCode()
            ];
        }
    }
}
