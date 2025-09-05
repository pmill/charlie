<?php

namespace Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_log_in_with_valid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret',
            'remember' => true,
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_log_in_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect();
        $this->assertGuest();
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/logout');

        $response->assertRedirect();
        $this->assertGuest();
    }
}
