<?php

namespace App;

class CoordinatesValidator
{
    /**
     * Check if a given point is inside the state of Rio Grande do Sul
     */
    public function isPointInsideRioGrandeDoSul(float $latitude, float $longitude): bool
    {
        return $this->isPointInPolygon(
            latitude: $latitude,
            longitude: $longitude,
            polygon: $this->coordinatesRioGrandeDoSul()
        );
    }

    /**
     * Calculate if a given point is inside a polygon
     */
    private function isPointInPolygon(float $latitude, float $longitude, array $polygon): bool
    {
        $inside = false;
        $x = $latitude;
        $y = $longitude;

        for ($i = 0, $j = count($polygon) - 1; $i < count($polygon); $j = $i++) {
            $xi = $polygon[$i][0];
            $yi = $polygon[$i][1];
            $xj = $polygon[$j][0];
            $yj = $polygon[$j][1];

            $intersect = (($yi > $y) != ($yj > $y)) && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }

    /**
     * The points of the polygon that defines the state of Rio Grande do Sul
     * @check <project_root>/docs/decisions/001-coordinates-validator.md
     *
     * @return array[<float>, <float>] - Latitude and Longitude
     */
    private function coordinatesRioGrandeDoSul(): array
    {
        /*
         * Check and update if changed: /docs/decisions/001-coordinates-validator.md
         */
        return [
            [-53.0014372, -34.0164553],
            [-52.5619841, -33.3215637],
            [-51.9906950, -32.4172837],
            [-50.6537533, -31.3353109],
            [-49.7604704, -29.6882764],
            [-49.5990658, -29.0566199],
            [-49.6396208, -28.4592594],
            [-50.4965544, -28.2852600],
            [-51.1447477, -27.6253685],
            [-52.1554899, -27.0789208],
            [-53.8034391, -27.0397859],
            [-54.5944548, -27.3915068],
            [-55.9347868, -28.3722954],
            [-57.1086287, -29.2242085],
            [-57.8392196, -30.2496885],
            [-57.3849821, -30.4867727],
            [-56.5643978, -30.5248569],
            [-55.9347868, -31.2881599],
            [-55.5282927, -31.1660299],
            [-54.4845915, -31.7844358],
            [-53.3969450, -32.7967266],
            [-53.7265348, -33.7154158],
            [-53.0014372, -34.0164553],
        ];
    }

}
