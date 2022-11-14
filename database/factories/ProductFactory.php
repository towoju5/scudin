<?php

namespace Database\Factories;

use App\Models\Product;
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
            'name'  =>  $this->faker->name,
            'slug'  =>  $this->faker->slug,
            'original_price'  =>  $this->faker->unique()->numberBetween(1,20),
            'category_id'  =>  5,
            'sku'   =>  'EOR-SKU-'.$this->faker->unique()->numberBetween(1,20),
            'price' =>  $this->faker->unique()->numberBetween(1,20),
            'excerpt'   =>  $this->faker->text,
            'description'   =>  $this->faker->text,
            'state' =>  'active',
            'stock' =>  $this->faker->unique()->numberBetween(1,20),
            'ext_title' =>  $this->faker->text,
            'meta_keywords' =>  $this->faker->text,
            'meta_description'  =>  $this->faker->text,
        ];
    }
}
