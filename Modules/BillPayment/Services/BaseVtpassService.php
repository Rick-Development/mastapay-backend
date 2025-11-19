<?php

namespace Modules\BillPayment\Services;

class BaseVtpassService
{
    protected $baseUrl;
    protected $apiKey;
    protected $publicKey;
    protected $secretKey;

    public function __construct()
    {
        $this->baseUrl   = config('vtpass.base_url');
        $this->apiKey    = config('vtpass.api_key');
        $this->publicKey = config('vtpass.public_key');
        $this->secretKey = config('vtpass.secret_key');
    }

    protected function get($endpoint)
    {
        $ch = curl_init($this->baseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'api-key: ' . $this->apiKey,
            'public-key: ' . $this->publicKey
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        \Log::info($response);

        return json_decode($response, true);
    }

    protected function post($endpoint, $data)
    {
        $ch = curl_init($this->baseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'api-key: ' . $this->apiKey,
            'secret-key: ' . $this->secretKey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        curl_close($ch);
        \Log::info($response);

        return json_decode($response, true);
    }

    public function getCategories()
    {
        return $this->get('/service-categories');
    }

    public function getServices($identifier)
    {
        return $this->get("/services?identifier={$identifier}");
    }

    public function getVariations($serviceId)
    {
        return $this->get("/service-variations?serviceID={$serviceId}");
    }

    public function getOptions($serviceId, $optionName)
    {
        return $this->get("/options?serviceID={$serviceId}&name={$optionName}");
    }

    public function purchase($payload)
    {
        $payload['request_id'] = $this->generateRequestId();
        return $this->post('/pay', $payload);
    }

    public function requery($requestId)
    {
        return $this->post('/requery', ['request_id' => $requestId]);
    }

    public function balance()
    {
         return $this->get("/balance");
    }

    protected function generateRequestId()
    {
        return \Carbon\Carbon::now('Africa/Lagos')->format('YmdHi') . uniqid();
    }
}
