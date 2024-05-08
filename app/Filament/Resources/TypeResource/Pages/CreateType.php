<?php

namespace App\Filament\Resources\TypeResource\Pages;

use App\Filament\Resources\TypeResource;
use App\Traits\CrudDefaults;
use Filament\Resources\Pages\CreateRecord;

class CreateType extends CreateRecord
{
    use CrudDefaults;

    protected static string $resource = TypeResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
