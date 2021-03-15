<?php


namespace Lukeraymonddowning\Nightguard\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class Nightguard
 * @package Lukeraymonddowning\Nightguard\Facades
 *
 * @method static \Lukeraymonddowning\Nightguard\Nightguard create($model, $guard = null) Create a new guard
 * @method static string|\Lukeraymonddowning\Nightguard\Nightguard webDriver($driver = null) Get or set the driver for web.
 * @method static string|\Lukeraymonddowning\Nightguard\Nightguard apiDriver($driver = null) Get or set the driver for the API.
 * @method static \Lukeraymonddowning\Nightguard\Nightguard usingSanctum() Configure Nightguard to use the 'sanctum' driver.
 *
 * @see \Lukeraymonddowning\Nightguard\Nightguard
 */
class Nightguard extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'nightguard';
    }

}
