<?php

namespace Domainwarden\Sdk;

use Illuminate\Support\ServiceProvider;
use RuntimeException;

class DomainwardenServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/domainwarden.php', 'domainwarden'
        );

        $this->app->singleton(DomainwardenClient::class, function () {
            $apiToken = config('domainwarden.api_token');

            if (empty($apiToken)) {

                throw new RuntimeException(
                    'Domainwarden API token is not configured. ' .
                    'Please set DOMAINWARDEN_API_TOKEN in your .env file or publish the config with: ' .
                    'php artisan vendor:publish --tag=domainwarden-config'
                );
            }

            return new DomainwardenClient($apiToken);
        });

        $this->app->alias(DomainwardenClient::class, 'domainwarden');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/domainwarden.php' => config_path('domainwarden.php'),
        ], 'domainwarden-config');
    }
}