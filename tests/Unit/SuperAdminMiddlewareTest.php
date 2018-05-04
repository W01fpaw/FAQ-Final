<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Middleware\SuperAdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class SuperAdminMiddlewareTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_not_super_admin_redirect()
    {
        $user = factory(User::class)->make(['super_admin' => false]);

        $this->actingas($user);

        $request = Request::create('/superAdminOnlyPage/', 'GET');

        $middleware = new SuperAdminMiddleware;

        $response = $middleware->handle($request, function() {});

        $this->assertEquals($response, null);
    }

    public function test_super_admin_not_redirect()
    {
        $user = factory(User::class)->make(['super_admin' => true]);

        $this->actingas($user);

        $request = Request::create('/superAdminOnlyPage/', 'GET');

        $middleware = new SuperAdminMiddleware;

        $response = $middleware->handle($request, function() {});

        $this->assertEquals($response,null);
    }
}
