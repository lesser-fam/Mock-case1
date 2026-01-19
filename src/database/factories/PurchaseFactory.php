<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Item;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;
    
    public function definition()
    {
        return [
            'item_id' => Item::factory(),
            'buyer_id' => User::factory(),
            'payment_method' => 'card',
            'post_num' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'building' => null,
            'status' => 'paid',
        ];
    }
}
