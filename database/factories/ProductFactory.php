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
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->text(100),
            'image' => $this->faker->word.'.jpg',
            'price' => rand(100,300),
            "color"=>$this->faker->randomElement(["red","blue","green","yellow"]),
            "size"=>rand(100,400),
            'discount_price' =>rand(100,300) - 70 ,
            "category_id"=> rand(1,20),
           
        ];
    }
}
