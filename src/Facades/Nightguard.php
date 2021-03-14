<?php


namespace Lukeraymonddowning\Nightguard\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class Nightguard
 * @package Lukeraymonddowning\Nightguard\Facades
 *
 * @method static \Lukeraymonddowning\Nightguard\Nightguard create($model, $guard = null)
 * @method static string|\Lukeraymonddowning\Nightguard\Nightguard webDriver($driver = null)
 * @method static string|\Lukeraymonddowning\Nightguard\Nightguard apiDriver($driver = null)
 * @method static \Lukeraymonddowning\Nightguard\Nightguard usingSanctum()
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
