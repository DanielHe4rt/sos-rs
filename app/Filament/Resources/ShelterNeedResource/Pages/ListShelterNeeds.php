<?php

namespace App\Filament\Resources\ShelterNeedResource\Pages;

use App\Filament\Resources\ShelterNeedResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShelterNeeds extends ListRecords
{
    protected static string $resource = ShelterNeedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
