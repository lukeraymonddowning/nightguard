<?php

namespace Lukeraymonddowning\Nightguard\Tests;

use Lukeraymonddowning\Nightguard\Providers\NightshiftServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Route;
use Spatie\LaravelRay\RayServiceProvider;

abstract class TestCase extends BaseTestCase
{

    protected function getPackageProviders($app)
    {
        return [RayServiceProvider::class, NightshiftServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();
        Route::get('login', fn() => abort(403))->name('login');
    }

}
