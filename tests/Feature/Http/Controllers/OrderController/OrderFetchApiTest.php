<?php

namespace Tests\Feature\Http\Controllers\OrderController;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderFetchApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_empty_orders()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->get('/api/orders');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'result' => []
        ]);
    }

    public function test_fetch_all_orders()
    {
        $order = Order::factory()->create();
        $user = $order->user;
        $this->actingAs($user, 'api');

        $response = $this->get('/api/orders');
        $response->assertStatus(200);
    }

    public function test_fetch_order_item_details()
    {
        $order = Order::factory()->create();
        $user = $order->user;
        $this->actingAs($user, 'api');

        $response = $this->get('/api/orders/' . $order->uuid);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'result' => [
                'id' => $order->id,
                'uuid' => $order->uuid,
                'billing_id' => $order->billing_id,
                'total_price' => $order->total_price,
                'status' => $order->status
            ]
        ]);

    }

    public function test_fetch_order_does_not_exist()
    {
        $order = Order::factory()->create();
        $user = $order->user;
        $this->actingAs($user, 'api');

        $response = $this->get('/api/orders/999');

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'result' => 'order does not exist'
        ]);

    }
}
