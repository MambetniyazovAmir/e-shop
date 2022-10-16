<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'price' => $this->faker->randomNumber(4),
            'property' => [
                'weight' => $this->faker->randomNumber(3),
                'length' => $this->faker->randomNumber(3),
                'width' => $this->faker->randomNumber(3),
            ],
            'category_id' => Category::all()->random()->id
        ];
    }
}
