<?php


namespace Lukeraymonddowning\Nightshift\Providers;


use Illuminate\Support\ServiceProvider;
use Lukeraymonddowning\Nightshift\Commands\CreateAuthCommand;
use Lukeraymonddowning\Nightshift\Nightguard;

class NightshiftServiceProvider extends ServiceProvider
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
