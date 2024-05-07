<?php

namespace Database\Seeders;

use App\Models\Neighborhood;
use Illuminate\Database\Seeder;

class NeighborhoodSeeder extends Seeder
{
    public function run(): void
    {
        Neighborhood::truncate();
        foreach (config('sos.neighborhood') as $neighborhood) {
            Neighborhood::create([
                'name' => $neighborhood,
                'slug' => str($neighborhood)->slug($neighborhood),
            ]);
        }
    }
}
