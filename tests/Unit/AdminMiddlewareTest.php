<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class AdminMiddlewareTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_not_admin_redirect()
    {
        $user = factory(User::class)->make(['admin' => false]);

        $this->actingas($user);

        $request = Request::create('/adminOnlyPage/', 'GET');

        $middleware = new AdminMiddleware;

        $response = $middleware->handle($request, function() {});

        $this->assertEquals($response, null);
    }

    public function test_admin_not_redirect()
    {
        $user = factory(User::class)->make(['admin' => true]);

        $this->actingas($user);

        $request = Request::create('/adminOnlyPage/', 'GET');

        $middleware = new AdminMiddleware;

        $response = $middleware->handle($request, function() {});

        $this->assertEquals($response,null);
    }

}
