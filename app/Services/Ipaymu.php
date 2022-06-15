<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Ipaymu
{
    public static function createPayment(array $data): Response
    {
        $headers = static::createHeaders($data);

        $response = Http::withHeaders($headers)->post(static::getConfig('api_url', '/v2/payment'), $data);

        return $response;
    }

    public static function createHeaders(array $body): array
    {
        $signature = static::createSignature($body);

        return [
            'signature' => $signature,
            'Content-Type' => 'application/json',
            'va' => static::getConfig('virtual_account'),
            'timestamp' => now()->format('YYYYMMDDhhmmss'),
        ];
    }

    public static function createSignature(array $body): string
    {
        $request = json_encode($body, JSON_UNESCAPED_SLASHES);

        $hash = hash('sha256', $request);

        $signature = 'POST:' . static::getConfig('virtual_account') . ':' . $hash . ':' . static::getConfig('api_key');

        $hashHmc = hash_hmac('sha256', $signature, static::getConfig('api_key'));

        return $hashHmc;
    }

    protected static function getConfig(string $config, string|null $param = null): string
    {
        if (!is_null($param)) {
            return config("ipaymu.{$config}") . $param;
        }

        return config("ipaymu.{$config}");
    }
}
