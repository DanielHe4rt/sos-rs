<?php

namespace App\Filament\Resources\NecessityResource\Pages;

use App\Filament\Resources\NecessityResource;
use App\Traits\CrudDefaults;
use Filament\Resources\Pages\CreateRecord;

class CreateNecessity extends CreateRecord
{
    use CrudDefaults;

    protected static string $resource = NecessityResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
