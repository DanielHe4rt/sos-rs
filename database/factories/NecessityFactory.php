<?php

namespace Database\Factories;

use App\Models\Necessity\Necessity;
use App\Models\Necessity\Type;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class NecessityFactory extends Factory
{
    protected $model = Necessity::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),

            'type_id' => Type::factory(),
        ];
    }
}
