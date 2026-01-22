<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;
use App\Models\User;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;    

    public function definition()
    {
        return [
            'user_id' => null,
            'user_name' => $this->faker->name(),
            'post_num' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'building' => $this->faker->secondaryAddress(),
            'image' => 'default.png',
        ];
    }
}
