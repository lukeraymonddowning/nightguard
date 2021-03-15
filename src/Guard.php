<?php


namespace Lukeraymonddowning\Nightguard;


use Illuminate\Support\Str;
use Lukeraymonddowning\Nightguard\Facades\Nightguard as NightguardFacade;

class Guard
{
    protected $guard;

    public function __construct($model, $guard = null)
    {
        $this->guard = $guard ?? Str::of($model)->classBasename()->singular()->kebab()->__toString();

        app()['config']->set(
            "auth.providers.{$this->getProviderName()}",
            ['driver' => 'eloquent', 'model' => $model]
        );

        $this->registerGuard($this->guard, NightguardFacade::webDriver());
        $this->registerGuard("api-{$this->guard}", NightguardFacade::apiDriver(), ['hash' => false]);
    }

    protected function getProviderName()
    {
        return Str::plural($this->guard);
    }

    protected function registerGuard($name, $driver, $options = [])
    {
        app()['config']->set(
            "auth.guards.{$name}",
            array_merge(['driver' => $driver, 'provider' => $this->getProviderName()], $options)
        );
    }
}
