<?php


namespace Lukeraymonddowning\Nightguard;


use Illuminate\Support\Str;

class Nightguard
{
    public function create($model, $guard = null)
    {
        $guard ??= Str::of($model)->classBasename()->singular()->kebab()->__toString();

        app()['config']->set(
            "auth.providers.{$this->getProviderName($guard)}",
            ['driver' => 'eloquent', 'model' => $model]
        );

        app()['config']->set(
            "auth.guards.$guard",
            ['driver' => 'session', 'provider' => $this->getProviderName($guard), 'hash' => false]
        );

        return $this;
    }

    protected function getProviderName($guard)
    {
        return Str::plural($guard);
    }
}
