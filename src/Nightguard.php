<?php


namespace Lukeraymonddowning\Nightguard;

class Nightguard
{
    protected $configuredGuards = [];

    public function create($model, $guard = null)
    {
        $this->configuredGuards[] = new Guard($model, $guard);
        return $this;
    }
}
