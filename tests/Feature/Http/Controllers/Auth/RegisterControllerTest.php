<?php

namespace Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'user@example.com',
        ]);

        $user = User::where('email', 'user@example.com')->first();
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_user_cant_register_with_invalid_input()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => '',
            'email' => 'userexample.com',
            'password' => 'password',
            'password_confirmation' => 'passw',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseMissing('users', [
            'name' => 'Test User',
            'email' => 'user@example.com',
        ]);

        Notification::assertNothingSent();
    }
}
