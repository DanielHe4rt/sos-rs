<?php

namespace App\Clients\GoogleMaps;

use GoogleMaps\Facade\GoogleMapsFacade;

class GoogleMapsClient
{
    public function getLocation(string $latitude, string $longitude)
    {
        $coordinates = sprintf('%s,%s', $latitude, $longitude);

        $response = GoogleMapsFacade::load('geocoding')
            ->setParam(['latlng' => $coordinates])
            ->get();

        $payload = json_decode($response, true);

        return MapsAddress::make($payload['results'][0]);
    }
}
