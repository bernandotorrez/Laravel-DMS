<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarTypeColour;

class CarTypeColourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarTypeColour::factory()
        ->count(10)
        ->forOneTypeModel()
        ->create();
    }
}
