<?php

use App\CoordinatesValidator;
use Illuminate\Support\Facades\File;

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('Coordinates validator', function () {

    $validator = new CoordinatesValidator;

    $northAmericaCapitals = File::json(base_path('tests/fixtures/north-america-capitals.json'));
    $northAmericaCapitalsCoordiantes = data_get($northAmericaCapitals, '*.geometry.coordinates');

    // North America capitals are outside of Rio Grande do Sul
    foreach ($northAmericaCapitalsCoordiantes as $coordinates) {
        $latitude = $coordinates[1];
        $longitude = $coordinates[0];

        $res = $validator->isPointInsideRioGrandeDoSul($latitude, $longitude);

        expect($res)->toBeFalse();
    }

    /*
     * Points inside of Rio Grande do Sul
     * Check and update if changed: /docs/decisions/001-coordinates-validator.md
     */
    $pointsInside = [
        [-55.2353954, -29.4169465],
        [-54.4224072, -28.6484905],
        [-52.8403759, -28.3008289],
        [-51.6758251, -28.7641229],
        [-51.6648388, -29.7799482],
        [-52.9612255, -30.6627960],
        [-54.5542431, -30.5871644],
        [-53.3237743, -29.6845482],
        [-55.4661083, -30.3125053],
        [-55.3452587, -28.8122653],
        [-52.8953075, -27.9229097],
        [-50.7969189, -28.7063227],
        [-51.9834423, -30.5304019],
        [-53.4226513, -31.4345952],
        [-52.4778271, -29.8180828],
        [-53.5654736, -29.2445434],
        [-56.1802197, -29.6559105],
        [-55.9604931, -30.4167774],
        [-54.2356396, -31.1153408],
    ];

    foreach ($pointsInside as $point) {
        $latitude = $point[0];
        $longitude = $point[1];

        $res = $validator->isPointInsideRioGrandeDoSul($latitude, $longitude);

        expect($res)->toBeTrue();
    }


});
