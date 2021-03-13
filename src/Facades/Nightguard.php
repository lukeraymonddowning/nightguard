<?php


namespace Lukeraymonddowning\Nightguard\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class Nightguard
 * @package Lukeraymonddowning\Nightguard\Facades
 *
 * @method static \Lukeraymonddowning\Nightguard\Nightguard create($model, $guard = null)
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
