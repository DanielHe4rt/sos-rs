<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum VictimStatusEnum: string implements HasLabel
{
    case Danger = 'danger';
    case Sheltered = 'sheltered';
    case Safe = 'safe';

    case Missed = 'missed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Danger => 'Em Perigo',
            self::Sheltered => 'Abrigado',
            self::Safe => 'Fora de Risco',
            self::Missed => 'Desaparecido',
        };
    }
}
