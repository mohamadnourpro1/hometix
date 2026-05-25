<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $productName = $this->faker->randomElement([
            'DC 12V Power Adapter',
            '2 Channel Relay Module',
            'Smart WiFi Switch',
            'Digital Multimeter Probe Set',
            'LED Driver 24V',
            'USB-C PD Trigger Board',
            'Programmable Timer Relay',
            'Motion Sensor Module',
            'Terminal Block Connector Kit',
            'Lithium Battery Charger Board',
        ]).' '.$this->faker->unique()->numberBetween(100, 999);

        return [
            'category_id' => Category::factory(),
            'name' => $productName,
            'price' => $this->faker->randomFloat(2, 5, 500),
            'short_description' => $this->faker->sentence(10),
            'description' => $this->faker->paragraphs(2, true),
            'is_popular' => $this->faker->boolean(30),
        ];
    }
}
