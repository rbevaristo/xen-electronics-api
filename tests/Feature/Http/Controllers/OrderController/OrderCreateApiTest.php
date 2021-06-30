<?php

namespace Tests\Feature\Http\Controllers\OrderController;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderCreateApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_validate_all_required_fields()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->post('/api/orders', []);

        $response->assertStatus(400);
        $response->assertJsonMissingValidationErrors();
    }

    public function test_validate_all_invalid_format()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->post('/api/orders', [
            'totalPrice' => 'test',
            'status' => 'test',
            'uuid' => 'test',
            'address' => 'test'
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'result' => [
                "totalPrice" => [
                    "The total price must be a number."
                ],
                "status" => [
                    "The status must be a number."
                ]
            ]
        ]);
    }

    public function test_order_already_exist_by_uuid()
    {
        $order = Order::factory()->create();
        $user = $order->user;
        $this->actingAs($user, 'api');
        $response = $this->post('/api/orders', [
            'totalPrice' => 1,
            'status' => 2,
            'uuid' => $order->uuid,
            'address' => 'test'
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'result' => 'order already exist'
        ]);
    }

    public function test_create_order_for_user()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->post('/api/orders', [
            'totalPrice' => 1,
            'status' => 2,
            'uuid' => 'test_uuid',
            'address' => 'test'
        ]);

        $response->assertStatus(201);

    }
}
