<?php namespace Gufran\AuthNet\LaravelBridge\ServiceProviders;

use Gufran\AuthNet\API\Manager;
use Gufran\AuthNet\Entities\Configuration;
use Illuminate\Support\ServiceProvider;

class AuthNetServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot()
    {
        $this->package('gufran/authnet');
    }

    public function register()
    {
        $this->app->bind('authNetManager', function($app) {

            $configuration = array(
              'loginId' => $app['config']->get('authnet::login_id'),
              'transactionKey' => $app['config']->get('authnet::key'),
              'mode' => $app['config']->get('authnet::mode', 'development'),
            );

            $configBall = new Configuration($configuration);
            return new Manager($configBall);
        });
    }
} 