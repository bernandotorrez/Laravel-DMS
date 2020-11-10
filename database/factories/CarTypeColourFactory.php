<?php

namespace Database\Factories;

use App\Models\CarTypeColour;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CarTypeModel;

class CarTypeColourFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CarTypeColour::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_type_model' => CarTypeModel::factory(),
            'colour' => $this->faker->colorName()
        ];
    }
}
