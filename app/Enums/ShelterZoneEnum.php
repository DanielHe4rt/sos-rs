<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ShelterZoneEnum: string implements HasLabel
{
    case NORTH = 'north';
    case SOUTH = 'south';
    case EAST = 'east';
    case WEST = 'west';
    case CENTER = 'center';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NORTH => 'North',
            self::SOUTH => 'South',
            self::EAST => 'East',
            self::WEST => 'West',
            self::CENTER => 'Center',
        };
    }
}
