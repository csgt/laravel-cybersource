<?php namespace Credibility\LaravelCybersource\Providers;

use Credibility\LaravelCybersource\Cybersource;
use Credibility\LaravelCybersource\SOAPClient;
use Credibility\LaravelCybersource\SOAPClientFactory;
use Credibility\LaravelCybersource\SOAPRequester;
use Illuminate\Support\ServiceProvider;

class LaravelCybersourceServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
        $namespace = 'laravel-cybersource';
        $path = __DIR__ . '/../../..';
		$this->package('credibility/laravel-cybersource', $namespace, $path);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind('cybersource', function($app) {
            $client = new SOAPClient($app);
            $factory = new SOAPClientFactory($app);
            $requester = new SOAPRequester($client, $app, $factory);
            return new Cybersource($requester, $app);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('cybersource');
	}

}