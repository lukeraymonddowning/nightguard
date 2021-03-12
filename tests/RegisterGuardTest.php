<?php

namespace Lukeraymonddowning\Nightguard\Tests;


use Illuminate\Foundation\Auth\User;
use Lukeraymonddowning\Nightguard\Facades\Nightguard;
use Route;

class RegisterGuardTest extends TestCase
{

    /** @test */
    public function it_can_register_a_new_guard_based_on_a_authenticatable_model()
    {
        Nightguard::create(Administrator::class, 'admin');

        $this->get('test')->assertRedirect('login');
        $this->be(new BasicUser)->get('test')->assertRedirect('login');
        $this->be(new Administrator(), 'admin')->get('test')->assertSee("Hello World");
    }

    protected function setUp(): void
    {
        parent::setUp();

        Route::get(
            'test',
            function () {
                return "Hello World";
            }
        )->middleware('auth:admin');
    }

}

class Administrator extends User
{

}

class BasicUser extends User
{

}
