<?php

namespace Database\Factories;

use App\Models\ReturnModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ReturnModelFactory extends Factory
{
  /**
   * Define the model's default state.
   * 
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
        'user_id' => 1,
        'title' => $this->faker->title(),
        'details' => $this->faker->realText(),
        'product_id' => $this->faker->realText(),
        'shop_id' => 1,
      ];
  }
}
