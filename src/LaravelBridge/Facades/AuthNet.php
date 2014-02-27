<?php namespace Gufran\AuthNet\LaravelBridge\Facades;

use Illuminate\Support\Facades\Facade;

class AuthNet Extends Facade {

    public static function getFacadeAccessor()
    {
        return 'authNetManager';
    }
}
