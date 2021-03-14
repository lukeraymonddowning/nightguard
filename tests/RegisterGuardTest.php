<?php

namespace Lukeraymonddowning\Nightguard\Tests;


use Illuminate\Foundation\Auth\User;
use Illuminate\Testing\Fluent\Concerns\Has;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\SanctumServiceProvider;
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

    /** @test */
    public function it_can_be_told_to_use_a_different_driver_for_the_web()
    {
        Nightguard::webDriver('sanctum')->create(\App\Models\Administrator::class);

        Route::get(
            'test',
            function () {
                return "Hello World";
            }
        )->middleware(['auth:administrator']);

        expect(config('auth.guards.administrator.driver'))->toEqual('sanctum');

        $this->get('test')->assertRedirect('login');

        Sanctum::actingAs(new BasicUser());
        $this->get('test')->assertRedirect('login');

        Sanctum::actingAs(new Administrator(), [], 'administrator');
        $this->get('test')->assertSee("Hello World");
    }

    /** @test */
    public function it_can_be_told_to_use_a_different_driver_for_the_api()
    {
        Nightguard::apiDriver('sanctum')->create(\App\Models\Administrator::class);

        Route::get(
            'test',
            function () {
                return "Hello World";
            }
        )->middleware(['auth:api-administrator']);

        expect(config('auth.guards.api-administrator.driver'))->toEqual('sanctum');

        $this->getJson('test')->assertUnauthorized();

        Sanctum::actingAs(new BasicUser());
        $this->getJson('test')->assertUnauthorized();

        Sanctum::actingAs(new Administrator(), [], 'api-administrator');
        $this->getJson('test')->assertSee("Hello World");
    }

    /** @test */
    public function there_is_a_shortcut_for_sanctum_driver_use()
    {
        Nightguard::usingSanctum()->create(\App\Models\Administrator::class);

        Route::get(
            'test',
            function () {
                return "Hello World";
            }
        )->middleware(['auth:administrator']);

        Route::get(
            'api/test',
            function () {
                return "Hello World";
            }
        )->middleware(['auth:api-administrator']);

        $this->get('test')->assertRedirect('login');
        Sanctum::actingAs(new Administrator(), [], 'administrator');
        $this->get('test')->assertSee("Hello World");

        $this->getJson('api/test')->assertUnauthorized();
        Sanctum::actingAs(new Administrator(), [], 'api-administrator');
        $this->getJson('api/test')->assertSee("Hello World");
    }

    protected function getPackageProviders($app)
    {
        return array_merge([SanctumServiceProvider::class], parent::getPackageProviders($app));
    }

}

class Administrator extends User
{
    use HasApiTokens;
}

class BasicUser extends User
{
    use HasApiTokens;
}

class ComplexUserClass extends User
{
    use HasApiTokens;
}
