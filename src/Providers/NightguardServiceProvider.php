<?php


namespace Lukeraymonddowning\Nightguard\Providers;


use Illuminate\Support\ServiceProvider;
use Lukeraymonddowning\Nightguard\Commands\CreateAuthCommand;
use Lukeraymonddowning\Nightguard\Nightguard;

class NightguardServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('nightguard', Nightguard::class);
    }

    public function boot()
    {
        $this->commands(CreateAuthCommand::class);
    }

}
