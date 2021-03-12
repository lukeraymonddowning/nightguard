<?php

namespace Lukeraymonddowning\Nightguard\Tests;

use Lukeraymonddowning\Nightguard\Providers\NightguardServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Route;
use Spatie\LaravelRay\RayServiceProvider;

abstract class TestCase extends BaseTestCase
{

    protected function getPackageProviders($app)
    {
        return [RayServiceProvider::class, NightguardServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();
        Route::get('login', fn() => abort(403))->name('login');
        $this->loadMigrationsFrom(__DIR__ . '/../mocks/migrations');
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set(
            'database.connections.testbench',
            [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]
        );
    }

}
