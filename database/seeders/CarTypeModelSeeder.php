<?php

namespace Database\Seeders;

use App\Models\CarModel;
use App\Models\CarTypeModel;
use Illuminate\Database\Seeder;

class CarTypeModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CarTypeModel::factory()->count(10)->for(CarModel::factory()->state(['model_name' => 'Asperiores.']))->create();
        CarTypeModel::factory()
        ->count(10)
        ->forOneModel()
        ->create();

        CarTypeModel::factory()
        ->count(10)
        ->hasColors()
        ->create();
    }
}
