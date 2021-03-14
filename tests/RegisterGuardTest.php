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
        Route::get(
            'test',
            function () {
                return "Hello World";
            }
        )->middleware('auth:admin');

        Nightguard::create(Administrator::class, 'admin');

        $this->get('test')->assertRedirect('login');
        $this->be(new BasicUser)->get('test')->assertRedirect('login');
        $this->be(new Administrator(), 'admin')->get('test')->assertSee("Hello World");
    }

    /** @test */
    public function a_guard_can_be_created_passing_only_the_model()
    {
        Route::get(
            'test',
            function () {
                return "Hello World";
            }
        )->middleware('auth:administrator');

        Nightguard::create(Administrator::class);

        $this->get('test')->assertRedirect('login');
        $this->be(new BasicUser)->get('test')->assertRedirect('login');
        $this->be(new Administrator(), 'administrator')->get('test')->assertSee("Hello World");
    }

    /** @test */
    public function it_works_with_complex_model_names()
    {
        Route::get(
            'test',
            function () {
                return "Hello World";
            }
        )->middleware('auth:complex-user-class');

        Nightguard::create(ComplexUserClass::class);

        $this->get('test')->assertRedirect('login');
        $this->be(new BasicUser)->get('test')->assertRedirect('login');
        $this->be(new ComplexUserClass(), 'complex-user-class')->get('test')->assertSee("Hello World");
    }

    /** @test */
    public function it_registers_a_token_auth()
    {
        Route::get(
            'test',
            function () {
                return "Hello World";
            }
        )->middleware(['api', 'auth:api-administrator']);

        Nightguard::create(\App\Models\Administrator::class);

        $this->getJson('test')->assertUnauthorized();
        $this->be(new BasicUser)->getJson('test')->assertUnauthorized();
        $this->be(new Administrator(), 'api-administrator')->getJson('test')->assertSee("Hello World");
    }

}

class Administrator extends User
{

}

class BasicUser extends User
{

}

class ComplexUserClass extends User
{

}
