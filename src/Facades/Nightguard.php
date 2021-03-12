<?php


namespace Lukeraymonddowning\Nightguard\Facades;


use Illuminate\Support\Facades\Facade;

class Nightguard extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'nightguard';
    }

}
