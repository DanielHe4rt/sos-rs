<?php

namespace App\Filament\Resources\NecessityResource\Pages;

use App\Filament\Resources\NecessityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNecessities extends ListRecords
{
    protected static string $resource = NecessityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
