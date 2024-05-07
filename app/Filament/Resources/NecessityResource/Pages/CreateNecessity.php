<?php

namespace App\Filament\Resources\NecessityResource\Pages;

use App\Filament\Resources\NecessityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNecessity extends CreateRecord
{
    protected static string $resource = NecessityResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
