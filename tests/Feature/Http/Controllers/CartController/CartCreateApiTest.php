<?php

namespace Tests\Feature\Http\Conrollers\CartController;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCreateApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_cart_item()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $product = Product::factory()->create();

        $response = $this->post('/api/cart-items', ['product' => $product->id]);

        $response->assertStatus(201);
    }

    public function test_product_does_not_exist()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->post('/api/cart-items', ['product' => 999]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'result' => 'product does not exist'
        ]);
    }

    public function test_product_already_in_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $product = Product::factory()->create();

        $user->carts()->create(['product_id' => $product->id]);

        $response = $this->post('/api/cart-items', ['product' => $product->id]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'result' => 'product already in cart'
        ]);
    }
}
