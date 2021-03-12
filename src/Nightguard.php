<?php


namespace Lukeraymonddowning\Nightshift;


use Illuminate\Support\Str;

class Nightguard
{
    public function create($model, $guard)
    {
        app()['config']->set(
            "auth.providers.{$this->getProviderName($guard)}",
            ['driver' => 'eloquent', 'model' => $model]
        );

        app()['config']->set(
            "auth.guards.$guard",
            ['driver' => 'session', 'provider' => $this->getProviderName($guard), 'hash' => false]
        );
    }

    protected function getProviderName($guard)
    {
        return Str::plural($guard);
    }
}
