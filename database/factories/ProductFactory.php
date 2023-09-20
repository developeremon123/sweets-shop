<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
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
    public function definition(): array
    {
        $name = fake()->sentence(2);
        return [
            'category_id'=> Category::select('id')->get()->random()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'product_code' => fake()->numberBetween(100,10000),
            'product_price' => fake()->numberBetween(100,10000),
            'product_stock' => fake()->numberBetween(5,100),
            'alert_quantity' => fake()->numberBetween(1,10),
            'short_description' => fake()->paragraph(3),
            'long_description' => fake()->paragraph(6),
            'aditional_info' => fake()->paragraph(2),
            'product_image' => 'https://picsum.photos/300',
            'product_rating' => fake()->numberBetween(0,5),
        ];
    }
}
