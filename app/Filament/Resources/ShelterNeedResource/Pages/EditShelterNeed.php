<?php

namespace App\Filament\Resources\ShelterNeedResource\Pages;

use App\Filament\Resources\ShelterNeedResource;
use App\Traits\CrudDefaults;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditShelterNeed extends EditRecord
{
    use CrudDefaults;

    protected static string $resource = ShelterNeedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
