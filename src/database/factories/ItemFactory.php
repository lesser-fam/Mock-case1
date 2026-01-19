<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;
use App\Models\Condition;
use App\Models\Category;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name'=> $this->faker->word(),
            'brand' => $this->faker->company(),
            'price' => $this->faker->numberBetween(120, 10000),
            'detail' => $this->faker->sentence(),
            'condition_id' => Condition::factory(),
            'seller_id' => User::factory(),
            'image' => 'test.jpg',
        ];
    }
}
