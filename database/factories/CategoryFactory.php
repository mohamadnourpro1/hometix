<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->unique()->randomElement([
            'Power Supplies',
            'Circuit Protection',
            'Smart Sensors',
            'Relays and Contactors',
            'Switches and Buttons',
            'Cables and Connectors',
            'Adapters and Converters',
            'DIY Controller Boards',
            'LED Lighting Parts',
            'Battery Solutions',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
