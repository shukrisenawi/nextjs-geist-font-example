<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $categories = [
            'Sticker' => 'Pelbagai jenis sticker custom untuk kegunaan peribadi atau perniagaan',
            'Baju Sublimation' => 'Baju sublimation berkualiti tinggi dengan design custom',
        ];

        $name = $this->faker->randomElement(array_keys($categories));
        
        return [
            'name' => $name,
            'slug' => strtolower(str_replace(' ', '-', $name)),
            'description' => $categories[$name],
            'image' => 'categories/' . strtolower(str_replace(' ', '_', $name)) . '.jpg',
            'is_active' => true,
        ];
    }
}
