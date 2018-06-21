<?php

namespace CodeInternetApplications\ShopifyOauth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * ShopifyShop Facade
 */
class ShopifyShop extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'shopify.shop.oauth.api';
    }
}
