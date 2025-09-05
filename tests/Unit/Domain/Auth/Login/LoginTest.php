<?php

namespace Tests\Unit\Domain\Auth\Login;

use App\Domain\Auth\Login\Login;
use App\Domain\Auth\Login\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login_attempt_successful_and_session_regenerated()
    {
        $credentials = ['email' => 'user@example.com', 'password' => 'secret'];

        $request = Mockery::mock(LoginRequest::class);

        $request->shouldReceive('validated')->once()->andReturn($credentials);
        $request->shouldReceive('filled')->with('remember')->once()->andReturn(true);

        $sessionMock = Mockery::mock();
        $sessionMock->shouldReceive('regenerate')->once();
        $request->shouldReceive('session')->once()->andReturn($sessionMock);

        Auth::shouldReceive('attempt')
            ->once()
            ->with($credentials, true)
            ->andReturn(true);

        $login = new Login;

        $result = $login($request);

        $this->assertTrue($result);
    }

    public function test_login_attempt_fails_and_session_not_regenerated()
    {
        $credentials = ['email' => 'user@example.com', 'password' => 'wrong'];

        $request = Mockery::mock(LoginRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($credentials);
        $request->shouldReceive('filled')->with('remember')->once()->andReturn(false);

        $request->shouldReceive('session')->never();

        Auth::shouldReceive('attempt')
            ->once()
            ->with($credentials, false)
            ->andReturn(false);

        $login = new Login;

        $result = $login($request);

        $this->assertFalse($result);
    }
}
