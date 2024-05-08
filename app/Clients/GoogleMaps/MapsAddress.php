<?php

namespace App\Clients\GoogleMaps;

readonly class MapsAddress
{
    public function __construct(
        public string $fullAddress,
        public string $latitude,
        public string $longitude,
        public string $number,
        public string $street,
        public string $city,
        public string $state,
        public string $country,
        public string $postalCode,
    )
    {
    }

    public static function make(array $payload): self
    {

        return new self(
            fullAddress: $payload['formatted_address'],
            latitude: $payload['geometry']['location']['lat'],
            longitude: $payload['geometry']['location']['lng'],
            number: $payload['address_components'][0]['long_name'],
            street: $payload['address_components'][1]['long_name'],
            city: $payload['address_components'][2]['long_name'],
            state: $payload['address_components'][3]['long_name'],
            country: $payload['address_components'][4]['long_name'],
            postalCode: $payload['address_components'][5]['long_name'],
        );

    }
}
