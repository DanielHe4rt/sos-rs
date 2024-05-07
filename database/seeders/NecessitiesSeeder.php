<?php

namespace Database\Seeders;

use App\Models\Necessity\Necessity;
use App\Models\Necessity\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NecessitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Necessity::truncate();
        Type::truncate();
        foreach (config('sos.necessity_types') as $type) {
            Type::create($type);
        }

        foreach (config('sos.necessities') as $necessity) {
            Necessity::create($necessity);
        }

    }
}
