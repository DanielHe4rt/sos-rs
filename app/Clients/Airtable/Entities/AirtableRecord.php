<?php

namespace App\Clients\Airtable\Entities;

use App\Clients\Airtable\Enums\NeedVolunteersEnum;
use App\Enums\ShelterZoneEnum;

class AirtableRecord
{

    public function __construct(
        public string             $id,
        public string             $institution_name,
        public string             $neighborhood,
        public string             $last_modified,
        public string             $demands_text,
        public ShelterZoneEnum    $zone,
        public NeedVolunteersEnum $need_volunteers,
        public string             $address,
        public array              $institution_type,
        public string             $city,
        public string             $volunteer_name,
        public string             $volunteer_whatsapp,
        public string             $responsible_name,
        public string             $responsible_phone,
        public ?array             $demands = []
    )
    {
    }

    public static function make(array $data): self
    {
        dump($data);
        return new self(
            id: $data['id'],
            institution_name: $data['nome_da_instituição'] ?? '',
            neighborhood: $data['bairro'][0] ?? '',
            last_modified: $data['última_modificação'],
            demands_text: $data['demandas-texto-'] ?? '',
            zone: isset($data['zona_do_bairro']) ? ShelterZoneEnum::makeFromAirtable($data['zona_do_bairro'][0]) : ShelterZoneEnum::Unknown,
            need_volunteers: isset($data['precisa_voluntários?']) ? NeedVolunteersEnum::makeFromAirtable($data['precisa_voluntários?'][0]) : NeedVolunteersEnum::Unknown,
            address: $data['endereço'] ?? '',
            institution_type: $data['tipo_instituição'] ?? [],
            city: $data['cidade'][0] ?? '',
            volunteer_name: $data['voluntário_nome'] ?? '',
            volunteer_whatsapp: $data['voluntário_whats'] ?? '',
            responsible_name: $data['nome_responsável-_centro/_instituição-'] ?? '',
            responsible_phone: $data['telefone_do_responsável'] ?? '',
            demands: $data['demandas'] ?? []
        );
    }

}
