<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_validation_required_fields()
    {
        $response = $this->post('/api/login', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_login_validation_invalid_email()
    {
        $response = $this->post('/api/login', [
            'email' => 'bukan-email',
            'password' => 'password123'
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password123'
        ]);

        $response->assertStatus(200);
    }

    public function test_login_with_wrong_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'salah'
        ]);

        $response->assertStatus(401);
    }
}
