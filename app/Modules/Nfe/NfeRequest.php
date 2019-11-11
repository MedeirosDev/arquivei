<?php

namespace App\Modules\Nfe;
use GuzzleHttp\Client;

class NfeRequest
{
    /** @var \GuzzleHttp\Client */
    private $http;

    /** @var NfeResponse */
    private $response;


    public function __construct()
    {
        $this->makeHttpClient();
    }

    private function makeHttpClient(): void
    {
        $config = [
            'base_uri' => config('arquivei.endpoint') . config('arquivei.version') . '/',
            'headers' => [
                'x-api-id' => config('arquivei.api.id'),
                'x-api-key' => config('arquivei.api.key'),
                'content-type' => 'application/json',
                'accept' => 'application/json',
            ],
        ];

        $this->http = new Client($config);
    }

    public function get(int $cursor = 0): NfeResponse
    {
        $request = $this->http->get("nfe/received/?limit=50&cursor={$cursor}");

        return $this->response = new NfeResponse($request);
    }

}
