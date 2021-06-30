<?php

namespace Database\Factories;

use App\Models\Billing;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'uuid' => $this->faker->uuid,
            'billing_id' => Billing::factory()->create()->id,
            'total_price' => $this->faker->numberBetween(10, 1000),
            'status' => $this->faker->numberBetween(1, 5)
        ];
    }
}
