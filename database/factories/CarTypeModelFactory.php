<?php

namespace Database\Factories;

use App\Models\CarTypeModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CarModel;

class CarTypeModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CarTypeModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_model' => CarModel::factory(),
            'type_model_name' => $this->faker->name()
        ];
    }
}
