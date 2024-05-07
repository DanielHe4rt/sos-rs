<?php

namespace Database\Factories;

use App\Models\Necessity\Necessity;
use App\Models\Shelter\Shelter;
use App\Models\Shelter\ShelterNeed;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ShelterNeedFactory extends Factory
{
    protected $model = ShelterNeed::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'type_id' => $this->faker->randomNumber(),

            'shelter_id' => Shelter::factory(),
            'necessity_id' => Necessity::factory(),
        ];
    }
}
