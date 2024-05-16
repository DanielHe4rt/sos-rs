<?php

namespace App\Traits;

trait HasTranslatedNavigation
{
    abstract protected static function navigationSingular(): string;

    abstract protected static function navigationPlural(): string;

    public static function getModelLabel(): string
    {
        return self::navigationSingular();
    }

    public static function getPluralLabel(): ?string
    {
        return self::navigationPlural();
    }

    public static function getNavigationLabel(): string
    {
        return self::navigationPlural();
    }
}
