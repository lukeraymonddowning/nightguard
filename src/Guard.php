<?php


namespace Lukeraymonddowning\Nightguard;


use Illuminate\Support\Str;

class Guard
{
    protected $webDriver = 'session';
    protected $apiDriver = 'token';
    protected $guard;

    public function __construct($model, $guard = null)
    {
        $this->guard = $guard ?? Str::of($model)->classBasename()->singular()->kebab()->__toString();

        app()['config']->set(
            "auth.providers.{$this->getProviderName()}",
            ['driver' => 'eloquent', 'model' => $model]
        );

        $this->configureWeb();
        $this->configureApi();
    }

    protected function configureWeb()
    {
        $this->registerGuard($this->guard, $this->webDriver);
    }

    protected function configureApi()
    {
        $this->registerGuard("api-{$this->guard}", $this->apiDriver, ['hash' => false]);
    }

    protected function registerGuard($name, $driver, $options = [])
    {
        app()['config']->set(
            "auth.guards.{$name}",
            array_merge(['driver' => $driver, 'provider' => $this->getProviderName()], $options)
        );
    }

    protected function getProviderName()
    {
        return Str::plural($this->guard);
    }
}
