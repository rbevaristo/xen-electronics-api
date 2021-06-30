<?php

namespace Tests\Feature\Http\Controllers\AuthController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_invalid_required_fields()
    {
        $response = $this->post('/api/login', []);

        $response->assertStatus(400);
        $response->assertJsonMissingValidationErrors();
    }

    public function test_unauthorised_when_user_not_exist()
    {
        $response = $this->post('/api/login', [
            'username' => 'test',
            'password' => 'testpassword'
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
            'result' => 'Unauthorised'
        ]);
    }

    public function test_successful_login()
    {
        User::create(['name' => 'testUser', 'username' => 'testUser', 'email' => 'testEmail', 'password' => Hash::make('testUser')]);

        $this->withoutExceptionHandling();
        $response = $this->post('/api/login', [
            'username' => 'testUser',
            'password' => 'testUser'
        ]);

        $response->assertStatus(200);
    }
}
