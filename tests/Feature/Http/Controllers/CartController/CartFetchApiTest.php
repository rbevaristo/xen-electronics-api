<?php

namespace Tests\Feature\Http\Conrollers\CartController;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartFetchApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_empty_cart_items()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->get('/api/cart-items');

        $response->assertStatus(200);
        $response->json([
            'success' => true,
            'result' => []
        ]);
    }

    public function test_fetch_all_cart_items()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $product = Product::factory()->create();

        $user->carts()->create(['product_id' => $product->id]);

        $response = $this->get('/api/cart-items');

        $response->assertStatus(200);
        $response->json([
            'success' => true,
            'result' => [
                [
                    'user_id' => $user->id,
                    'product_id' => $product->id
                ]
            ]
        ]);
    }
}
