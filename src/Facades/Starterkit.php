<?php

namespace AcitJazz\Starterkit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AcitJazz\Starterkit\Starterkit
 */
class Starterkit extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AcitJazz\Starterkit\Starterkit::class;
    }
}
