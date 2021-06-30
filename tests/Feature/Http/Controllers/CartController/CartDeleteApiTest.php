<?php

namespace Tests\Feature\Http\Conrollers\CartController;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartDeleteApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_cart_item()
    {

        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $product = Product::factory()->create();

        $user->carts()->create(['product_id' => $product->id]);

        $response = $this->delete('/api/cart-items/' . $product->id);

        $response->assertStatus(200);
    }

    public function test_product_does_not_exist_in_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->delete('/api/cart-items/999');

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'result' => 'product on cart not found'
        ]);
    }
}
