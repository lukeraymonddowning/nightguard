<?php


namespace Lukeraymonddowning\Nightguard;

class Nightguard
{
    protected $configuredGuards = [];
    protected $webDriver = 'session';
    protected $apiDriver = 'token';

    public function create($model, $guard = null)
    {
        $this->configuredGuards[] = new Guard($model, $guard);
        return $this;
    }

    public function usingSanctum()
    {
        return $this
            ->webDriver('sanctum')
            ->apiDriver('sanctum');
    }

    public function webDriver($driver = null)
    {
        if ($driver) {
            $this->webDriver = $driver;
            return $this;
        }

        return $this->webDriver;
    }

    public function apiDriver($driver = null)
    {
        if ($driver) {
            $this->apiDriver = $driver;
            return $this;
        }

        return $this->apiDriver;
    }
}
