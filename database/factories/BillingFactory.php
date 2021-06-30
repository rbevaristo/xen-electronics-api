<?php

namespace Database\Factories;

use App\Models\Billing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BillingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Billing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::first()->id,
            'address' => $this->faker->address,
            'country' => $this->faker->countryCode,
            'city' => $this->faker->city,
            'postcode' => $this->faker->postcode
        ];
    }
}
