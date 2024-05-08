<?php

use App\CoordinatesValidator;
use Illuminate\Support\Facades\File;

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
