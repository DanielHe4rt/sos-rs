<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;

class AirtableClient
{
    public function getRecords(string $baseId, $table): array
    {
        $uri = sprintf('https://api.airtable.com/v0/%s/%s', $baseId, $table);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.airtable.api_key')
        ])->get($uri);

        return $response->json();
    }
}
