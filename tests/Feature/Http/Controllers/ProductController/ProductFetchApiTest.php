<?php

namespace Tests\Feature\Http\Controllers\ProductController;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductFetchApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_all_products()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    public function test_error_message_for_product_not_exist()
    {

        $response = $this->get('/api/products/999');

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'result' => 'Product does not exist'
        ]);
    }

    public function test_can_fetch_product_by_id()
    {
        $this->withoutExceptionHandling();
        $product = Product::factory()->create();

        $response = $this->get('/api/products/'.$product->id);

        $response->assertStatus(200);
    }

}
