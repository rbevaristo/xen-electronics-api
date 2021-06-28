<?php

namespace Tests\Feature\Http\Controllers\ProductController;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCreateApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_error_message_for_required_fields()
    {
        $jsonData = [];

        $response = $this->post('/api/products', $jsonData);

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
        $jsonData = [
            'name' => 'test name',
            'price' => 'test',
            'quantity' => 'test',
            'category' => 'test'
        ];

        $response = $this->post('/api/products', $jsonData);

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

    public function test_category_does_not_exist()
    {
        $jsonData = [
            'name' => 'test name',
            'price' => 0,
            'quantity' => 0,
            'category' => 999
        ];

        $response = $this->post('/api/products', $jsonData);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'result' => 'category does not exist'
        ]);
    }

    public function test_product_already_exist()
    {

        $category = Category::create(['name' => 'test category', 'sort' => 0]);

        $category->products()->create([
            'name' => 'test name',
            'price' => 0,
            'quantity' => 0,
        ]);


        $jsonData = [
            'name' => 'test name',
            'price' => 0,
            'quantity' => 0,
            'category' => $category->id
        ];

        $response = $this->post('/api/products', $jsonData);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'result' => 'Product already exist'
        ]);
    }

    public function test_can_create_product()
    {
        $category = Category::create(['name' => 'test category', 'sort' => 0]);

        $jsonData = [
            'name' => 'test name',
            'price' => 0,
            'quantity' => 0,
            'category' => $category->id
        ];

        $response = $this->post('/api/products', $jsonData);

        $response->assertStatus(201);
    }
}
