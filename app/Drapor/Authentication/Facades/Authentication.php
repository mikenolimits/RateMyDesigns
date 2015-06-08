<?php
namespace TheMasqline\Drapor\Authentication\Facades;

use Illuminate\Support\Facades\Facade;

class Authentication extends Facade {
    protected static function getFacadeAccessor()
    {
        return 'Authentication';
    }

}