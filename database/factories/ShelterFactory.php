<?php

namespace Database\Factories;

use App\Models\Shelter\Shelter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ShelterFactory extends Factory
{
    protected $model = Shelter::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'neighborhood' => $this->faker->word(),
            'zone' => $this->faker->word(),
            'need_volunteers' => $this->faker->boolean(),
            'address' => $this->faker->address(),
            'pix' => $this->faker->word(),
            'phone_number' => $this->faker->phoneNumber(),
            'shelter_capacity_count' => $this->faker->randomNumber(),
            'sheltered_capacity_count' => $this->faker->randomNumber(),
            'is_pet_friendly' => $this->faker->boolean(),
        ];
    }
}
