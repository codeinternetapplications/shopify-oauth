<?php

namespace CodeInternetApplications\ShopifyOauth\Providers;

use Illuminate\Support\ServiceProvider;

use CodeInternetApplications\ShopifyOauth\Services\ShopifyShop;
use CodeInternetApplications\ShopifyOauth\Services\ShopifyShopAccessToken;

class ShopifyOauthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // force the root URL if available (base url)
        if ($app_url = env('SHOPIFY_APP_BASE_URL','')) {
            \URL::forceRootUrl($app_url);
        }

        // validate oauth requests
        $this->app->routeMiddleware([
            'shopify-hostname-validation'    => \CodeInternetApplications\ShopifyOauth\Http\Middleware\ShopifyHostnameValidator::class,
            'shopify-hmac-validation'        => \CodeInternetApplications\ShopifyOauth\Http\Middleware\ShopifyHmacValidator::class,
            'shopify-oauth-handler'          => \CodeInternetApplications\ShopifyOauth\Http\Middleware\ShopifyOauthRequestHandler::class,
        ]);

        // merge the general Shopify Oauth configuration
        $this->mergeConfigFrom(realpath(__DIR__ . '/../../config/shopify_oauth.php'), 'shopify_oauth');

        // load all Shopify Oauth migrations
        $this->loadMigrationsFrom(realpath(__DIR__ . '/../../database/migrations/'));

        // register routes
        include __DIR__ .'/../../routes/shopify-oauth.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // bind facades
        $this->app->bind('shopify.shop.oauth.api', ShopifyShop::class);
        $this->app->bind('shopify.access_token.oauth.api', ShopifyShopAccessToken::class);
    }
}
