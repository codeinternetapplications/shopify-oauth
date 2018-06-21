<?php

namespace CodeInternetApplications\ShopifyOauth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * ShopifyShopAccessToken Facade
 */
class ShopifyShopAccessToken extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'shopify.access_token.oauth.api';
    }
}
