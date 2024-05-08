<?php

namespace App\Traits;

trait CrudDefaults
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
