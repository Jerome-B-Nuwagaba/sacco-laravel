<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MLPredictionService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.ml_api.url', 'http://localhost:8001');
    }

    public function predict(array $memberData): ?array
    {
        try {
            $response = Http::timeout(10)
                ->post("{$this->baseUrl}/predict", $memberData);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('ML API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('ML API unreachable', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function isHealthy(): bool
    {
        try {
            return Http::timeout(3)
                ->get("{$this->baseUrl}/health")
                ->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}