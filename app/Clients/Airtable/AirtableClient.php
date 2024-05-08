<?php

namespace App\Clients\Airtable;

use App\Clients\Airtable\Entities\AirtableRecord;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class AirtableClient
{


    /**
     * @param string $baseId
     * @param $table
     * @return AirtableRecord[]
     * @throws ConnectionException
     */
    public function getRecords(string $baseId, $table): array
    {
        $uri = sprintf('https://api.airtable.com/v0/%s/%s', $baseId, $table);


        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.airtable.api_key')
        ])->get($uri);

        return $this->transformRecords($response->json());
    }


    private function transformRecords(array $data): array
    {
        return collect($data['records'])
            ->map(function ($record) {
                $record['fields']['id'] = $record['id'];
                $record = collect($record['fields'])
                    ->mapWithKeys(function ($value, $key) {
                        $key = str($key)
                            ->replace(['(', ')'], '-')
                            ->snake()
                            ->toString();
                        $key = normalizer_normalize($key);
                        return [$key => $value];
                    })->toArray();


                return AirtableRecord::make($record);
            })->toArray();
    }
}
