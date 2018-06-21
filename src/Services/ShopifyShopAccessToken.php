<?php

namespace CodeInternetApplications\ShopifyOauth\Services;

use Carbon\Carbon;
use CodeInternetApplications\ShopifyOauth\Models\Shop;
use CodeInternetApplications\ShopifyOauth\Models\ShopAccessToken;
use CodeInternetApplications\ShopifyOauth\Client\Provider\ShopifyResource;

/**
 * ShopifyShopAccessToken Service
 *
 * Interacts with the Shopify API.
 * Stores/updates store information and access token
 */
class ShopifyShopAccessToken
{
    /**
     * Get the request response fields for the sjp[]
     *
     * API value => column name
     */
    protected $request_response_fields = [
        'scope'                                 => 'scope',
        'associated_user_scope'                 => 'associated_user_scope',
        'associated_user.id'                    => 'associated_user_id',
        'associated_user.account_owner'         => 'associated_user_account_owner',
    ];

    /**
     *
     * @param ShopifyResource $shop_resource
     * @param arary $token_info
     * @return void
     */
    public function storeResource(Shop $shop, $access_token, $token_info_arr)
    {
        // get tokens
        $shop_access_token = $shop->access_tokens()->firstOrNew([
            'associated_user_id'  => data_get($token_info_arr, 'associated_user.id', 0),
        ]);

        // set token
        $shop_access_token->access_token = $access_token;

        // loop fields and store data
        foreach ($this->request_response_fields as $api_key => $column) {
            $shop_access_token->{$column} = data_get($token_info_arr, $api_key);
        }

        // make sure that account owner is filled with true or false
        $shop_access_token->associated_user_account_owner = data_get($token_info_arr, 'associated_user.account_owner', 0);

        // calculate the 'expire date'
        if ($seconds = data_get($token_info_arr, 'expires_in')) {
            $shop_access_token->expire_date = (new Carbon('now'))->addSeconds($seconds);
        }

        // save
        $shop_access_token->save();

        // store shop
        return $shop_access_token;
    }
}

