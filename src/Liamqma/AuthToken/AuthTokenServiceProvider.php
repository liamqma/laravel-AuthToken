<?php

namespace Liamqma\AuthToken;

use Illuminate\Support\ServiceProvider;

class AuthTokenServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $app = $this->app;

        $app->bind('liamqma.auth.token.repo', function () {
                    return new AuthTokenRepository();
                });
        $app->bind('liamqma.auth.token.hash', function () {
                    return new HashProvider();
                });
        $app->bind('liamqma.auth.token', function () {
                    return new AuthToken($app->make('liamqma.auth.token.repo'),$app->make('liamqma.auth.token.hash'), new \Encrypter);
                });
                
                
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }

}