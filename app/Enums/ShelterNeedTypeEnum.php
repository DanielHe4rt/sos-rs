<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ShelterNeedTypeEnum: int implements HasLabel
{
    case Need = 1;
    case Urgent = 2;
    case Donate = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Need => 'Necessita',
            self::Urgent => 'Necessita Urgentemente',
            self::Donate => 'Doação',
        };
    }
}
