<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = fake()->randomElement([
            ['Wireless Mouse', 'Peripherals', 500, 3000],
            ['Mechanical Keyboard', 'Peripherals', 1500, 7000],
            ['Gaming Monitor', 'Monitor', 8000, 25000],
            ['USB-C Hub', 'Peripherals', 800, 5000],
            ['Portable SSD', 'Storage', 2500, 12000],
            ['Wi-Fi Router', 'Networking', 1500, 10000],
        ]);
        $quantity = fake()->numberBetween(0, 30);

        return [
            'name' => $product[0].' '.fake()->bothify('??-###'),
            'category' => $product[1],
            'price' => fake()->randomFloat(2, $product[2], $product[3]),
            'quantity' => $quantity,
            'supplier' => fake()->company(),
            'status' => $quantity === 0 ? 'Out of Stock' : ($quantity <= 5 ? 'Low Stock' : 'Available'),
            'description' => fake()->sentence(),
        ];
    }
}
