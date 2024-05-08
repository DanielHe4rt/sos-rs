<?php

namespace Database\Factories;

use App\Models\Shelter\Shelter;
use App\Models\Victim\Victim;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VictimFactory extends Factory
{
    protected $model = Victim::class;

    public function definition(): array
    {
        return [
            'shelter_id' => Shelter::factory(),
            'status_id' => $this->faker->word(),
            'location' => $this->faker->word(),
            'name' => $this->faker->name(),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'notes' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
