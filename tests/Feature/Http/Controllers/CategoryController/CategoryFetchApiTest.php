<?php

namespace Tests\Feature\Http\Controllers\CategoryController;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryFetchApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_empty_categories()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');


        $response = $this->get('/api/categories');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'result' => []
        ]);
    }

    public function test_fetch_all_categories()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $this->withoutExceptionHandling();
        Category::factory(10)->create();
        $response = $this->get('/api/categories');

        $result = Category::orderBy('sort')->orderBy('name')->get();
        $response->assertStatus(200);
    }
}
