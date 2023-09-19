<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $client_name = fake()->name();
        return [
            'client_name' => $client_name,
            'client_name_slug' => Str::slug($client_name),
            'client_designation' => fake()->jobTitle().','.' '.fake()->company(),
            'client_message' => fake()->paragraph(),
        ];
    }
}
