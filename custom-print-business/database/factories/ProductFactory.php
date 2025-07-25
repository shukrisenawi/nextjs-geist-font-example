<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $isTshirt = $this->faker->boolean();
        
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->paragraph(3),
            'base_price' => $this->faker->randomFloat(2, 15, 100),
            'sizes' => $isTshirt ? ['S', 'M', 'L', 'XL', 'XXL'] : null,
            'materials' => $isTshirt 
                ? ['Cotton 100%', 'Polyester', 'Cotton Blend'] 
                : ['Vinyl', 'Transparent', 'Matte', 'Glossy'],
            'image' => 'products/' . $this->faker->image('public/storage/products', 640, 480, null, false),
            'gallery' => [
                'products/' . $this->faker->image('public/storage/products', 640, 480, null, false),
                'products/' . $this->faker->image('public/storage/products', 640, 480, null, false),
            ],
            'is_active' => true,
            'allow_custom_design' => true,
        ];
    }
}
