<?php

namespace CodeInternetApplications\ShopifyOauth\Events;

use CodeInternetApplications\ShopifyOauth\Models\Shop;
use Illuminate\Queue\SerializesModels;

/**
 * Event that is fired when Shopify callback took place
 *
 * This can be used to add additional request such as:
 *  - Install webhooks
 */
class PostShopifyCallbackEvent
{
    use SerializesModels;

    /**
     * The shop where the installation is completed for
     * @var Shop $shop
     */
    public $shop;

    /**
     * Create a new event instance.
     *
     * @param Shop $shop
     * @return void
     */
    public function __construct(Shop $shop)
    {
        // set shop
        $this->shop = $shop;
    }
}
