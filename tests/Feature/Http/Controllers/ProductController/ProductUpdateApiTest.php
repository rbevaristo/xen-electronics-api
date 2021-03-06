<?php

namespace Tests\Feature\Http\Controllers\ProductController;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductUpdateApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_error_message_for_required_fields()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $jsonData = [];

        $response = $this->put('/api/products/1', $jsonData);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'result' => [
                'name' => ['The name field is required.'],
                'price' => ['The price field is required.'],
                'quantity' => ['The quantity field is required.'],
                'category' => ['The category field is required.'],
            ]
        ]);
    }

    public function test_error_message_for_non_numeric_fields()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $jsonData = [
            'name' => 'test name',
            'price' => 'test',
            'quantity' => 'test',
            'category' => 'test'
        ];

        $response = $this->put('/api/products/1', $jsonData);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'result' => [
                'price' => ['The price must be a number.'],
                'quantity' => ['The quantity must be a number.'],
                'category' => ['The category must be a number.'],
            ]
        ]);
    }

    public function test_product_does_not_exist()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $jsonData = [
            'name' => 'test name',
            'price' => 0,
            'quantity' => 0,
            'category' => 999
        ];

        $response = $this->put('/api/products/999', $jsonData);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'result' => 'Product does not exist'
        ]);
    }

    public function test_category_does_not_exist()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $category = Category::create(['name' => 'test category', 'sort' => 0]);

        $product = Product::factory()->create();

        $jsonData = [
            'name' => 'test name',
            'price' => 0,
            'quantity' => 0,
            'category' => 999
        ];

        $response = $this->put('/api/products/' .$product->id, $jsonData);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'result' => 'category does not exist'
        ]);
    }

    public function test_can_update_product()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $category = Category::create(['name' => 'test category', 'sort' => 0]);
        $product = Product::factory()->create();
        $jsonData = [
            'name' => 'test name',
            'price' => 0,
            'quantity' => 0,
            'category' => $category->id
        ];

        $response = $this->put('/api/products/'. $product->id, $jsonData);

        $response->assertStatus(200);
    }
}
