<?php

namespace App\Clients\Airtable\Enums;

use Filament\Support\Contracts\HasLabel;

enum NeedVolunteersEnum: int implements HasLabel
{
    case Yes = 1;
    case No = 2;
    case Maybe = 3;
    case Urgent = 4;
    case Unknown = 5;


    public function getLabel(): ?string
    {
        return match ($this) {
            self::Yes => 'Sim',
            self::No => 'Não',
            self::Maybe => 'Talvez',
            self::Urgent => 'Urgente',
            self::Unknown => 'Não Informado'
        };
    }

    public static function makeFromAirtable(string $data): self
    {
        $data = trim($data);
        return match ($data) {
            'Sim' => self::Yes,
            'Não' => self::No,
            'Talvez' => self::Maybe,
            'URGENTE' => self::Urgent,
            default => self::Unknown
        };
    }
}
