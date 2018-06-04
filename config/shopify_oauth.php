<?php

return [

    /*
    |--------------------------------------------------------------------------
    | App API key
    |--------------------------------------------------------------------------
    |
    | This is the API Key as given in the Partners App entry and can be found
    | in the App Info part of your app in the Partners dashboard. It is
    | located in the App credentials segment.
    */
    'api_key'           => env('SHOPIFY_OAUTH_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | App API secret key
    |--------------------------------------------------------------------------
    |
    | This is the API secret key as given in the Partners App entry and can be
    | found in the App Info part of your app in the Partners dashboard.
    | It is located in the App credentials segment.
    */
    'api_secret_key'    => env('SHOPIFY_OAUTH_SECRET_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Scopes that we need to authorize
    |--------------------------------------------------------------------------
    |
    | Determine the scopes for this OAuth handshake. You will nee to re-auth
    | after each change in this scope. Make sure you use only the scopes
    | you really need. Otherwise Shopify will refuse your Public app
    | request when you submit it.
    |

    */
    'scopes'    => [
        'read_content',
        'write_content',
        'read_themes',
        'write_themes',
        'read_products',
        'write_products',
        // 'read_product_listings',
        // 'read_customers',
        // 'write_customers',
        // 'read_orders',
        // 'write_orders',
        // 'read_draft_orders',
        // 'write_draft_orders',
        // 'read_inventory',
        // 'write_inventory',
        // 'read_locations',
        // 'read_script_tags',
        // 'write_script_tags',
        // 'read_fulfillments',
        // 'write_fulfillments',
        // 'read_shipping',
        // 'write_shipping',
        // 'read_analytics',
        // 'read_users',
        // 'write_users',
        // 'read_checkouts',
        // 'write_checkouts',
        // 'read_reports',
        // 'write_reports',
        // 'read_price_rules',
        // 'write_price_rules',
        // 'read_marketing_events',
        // 'write_marketing_events',
        // 'read_resource_feedbacks',
        // 'write_resource_feedbacks',
        // 'read_shopify_payments_payouts',
        // 'unauthenticated_read_product_listings',
        // 'unauthenticated_write_checkouts',
        // 'unauthenticated_write_customers',
        // 'unauthenticated_read_content',
    ],
];