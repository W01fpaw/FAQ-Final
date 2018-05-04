<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Middleware\MemberMiddleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class MemberMiddlewareTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_not_member_redirect()
    {
        $user = factory(User::class)->make(['member' => false]);

        $this->actingas($user);

        $request = Request::create('/memberOnlyPage/', 'GET');

        $middleware = new memberMiddleware;

        $response = $middleware->handle($request, function() {});

        $this->assertEquals($response, null);
    }

    public function test_member_not_redirect()
    {
        $user = factory(User::class)->make(['member' => true]);

        $this->actingas($user);

        $request = Request::create('/memberOnlyPage/', 'GET');

        $middleware = new MemberMiddleware;

        $response = $middleware->handle($request, function() {});

        $this->assertEquals($response,null);
    }
}
