<?php

namespace App\Filament\Resources\NecessityResource\Pages;

use App\Filament\Resources\NecessityResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditNecessity extends EditRecord
{
    protected static string $resource = NecessityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
