<?php

// var it
$router = $this->app->router;

/*
| Shopify OAuth Controllers
*/
$this->app->router->group([
    'namespace'     => 'CodeInternetApplications\ShopifyOauth\Http\Controllers',
    'prefix'        => 'shopify',
    'middleware'    => [
        'shopify-hostname-validation',
        'shopify-hmac-validation',
    ]
], function() use ($router) {

    // Get Shopify authorize
    $router->get('authorize', [
        'as'            => 'shopify.oauth.authorize',
        'uses'          => 'ShopifyOauthController@initInstallationRequest',
    ]);

    // Get Shopify callback for offline token
    $router->get('callback', [
        'as'            => 'shopify.oauth.callback',
        'uses'          => 'ShopifyOauthController@handleOauthCallback',
    ]);
});
