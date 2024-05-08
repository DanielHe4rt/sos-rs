<?php

namespace App\Filament\Resources\ShelterResource\Pages;

use App\Filament\Resources\ShelterResource;
use App\Traits\CrudDefaults;
use Filament\Resources\Pages\CreateRecord;

class CreateShelter extends CreateRecord
{
    use CrudDefaults;

    protected static string $resource = ShelterResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
