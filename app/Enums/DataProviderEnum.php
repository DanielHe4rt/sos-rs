<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DataProviderEnum implements HasLabel
{
    CASE Website;
    case Airtable;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Website => 'Website',
            self::Airtable => 'Airtable',
        };
    }
}
