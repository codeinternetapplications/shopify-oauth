<?php

namespace CodeInternetApplications\ShopifyOauth\Services;

use CodeInternetApplications\ShopifyOauth\Models\Shop;
use CodeInternetApplications\ShopifyOauth\Client\Provider\ShopifyResource;

/**
 * ShopifyShop Service
 *
 * Interacts with the Shopify API.
 * Stores/updates store information and access token
 */
class ShopifyShop
{
    /**
     * Get the request response fields for the sjp[]
     *
     * API value => column name
     */
    protected $request_response_fields = [
        'name'                          => 'name',
        'email'                         => 'email',
        'customer_email'                => 'customer_email',
        'domain'                        => 'domain',
        'myshopify_domain'              => 'myshopify_domain',
        'timezone'                      => 'timezone',
        'iana_timezone'                 => 'iana_timezone',
        'primary_locale'                => 'primary_locale',
        'currency'                      => 'currency',
        'money_format'                  => 'money_format',
        'money_with_currency_format'    => 'money_with_currency_format',
        'weight_unit'                   => 'weight_unit',
        'plan_name'                     => 'plan_name',
        'plan_display_name'             => 'plan_display_name',
        'primary_location_id'           => 'primary_location_id',
    ];

    /**
     *
     * @param ShopifyResource $shop_resource
     * @param arary $token_info
     * @return void
     */
    public function storeResource(ShopifyResource $shop_resource)
    {
        // get response data
        $shop_response = $shop_resource->getResponse();

        // set shop id
        $shop_id = data_get($shop_response, 'id');

        // get shop or create new one
        $shop = Shop::firstOrNew([
            'id'    => $shop_id,
        ]);

        // loop fields and store data
        foreach ($this->request_response_fields as $api_key => $column) {
            $shop->{$column} = data_get($shop_response, $api_key);
        }

        // save and return fresh instance
        $shop->save();

        $shop = $shop->fresh();

        return $shop;
    }
}

