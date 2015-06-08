<?php namespace TheMasqline\Drapor\Authentication;

use Illuminate\Support\ServiceProvider;

class AuthenticationServiceProvider extends ServiceProvider {

    /**
     * Register# in IoC container
     */
    public function register()
    {
        $this->app->bind(
            'Authentication', 'TheMasqline\Drapor\Authentication\Authentication'
        );
    }

}