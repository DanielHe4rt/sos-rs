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

    case Unknown = 'unknown';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NORTH => 'North',
            self::SOUTH => 'South',
            self::EAST => 'East',
            self::WEST => 'West',
            self::CENTER => 'Center',
            self::Unknown => 'Não Informado',
        };
    }


    public static function makeFromAirtable(string $value): self
    {
        return match ($value) {
            'Zona Norte' => self::NORTH,
            'Zona Sul' => self::SOUTH,
            'Zona Leste' => self::EAST,
            'Zona Oeste' => self::WEST,
            'Zona Central' => self::CENTER,
        };
    }
}
