<?php

namespace App\Filament\Resources\ShelterNeedResource\Pages;

use App\Filament\Resources\ShelterNeedResource;
use Filament\Resources\Pages\CreateRecord;

class CreateShelterNeed extends CreateRecord
{
    protected static string $resource = ShelterNeedResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
