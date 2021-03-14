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
        app()['config']->set(
            "auth.guards.{$this->guard}",
            ['driver' => $this->webDriver, 'provider' => $this->getProviderName()]
        );
    }

    protected function configureApi()
    {
        app()['config']->set(
            "auth.guards.api-{$this->guard}",
            ['driver' => $this->apiDriver, 'provider' => $this->getProviderName(), 'hash' => false]
        );
    }

    protected function getProviderName()
    {
        return Str::plural($this->guard);
    }
}
