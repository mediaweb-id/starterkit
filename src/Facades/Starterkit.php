<?php

namespace MediaWebId\Starterkit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MediaWebId\Starterkit\Starterkit
 */
class Starterkit extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MediaWebId\Starterkit\Starterkit::class;
    }
}
