<?php

namespace CodeInternetApplications\ShopifyOauth\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class ShopifyResource implements ResourceOwnerInterface
{
    /**
     * Shopify response
     * @var array
     */
    protected $response;

    /**
     * Constructor
     *
     * @var array response
     */
    public function __construct(array $response)
    {
        // set response
        $this->response = $response;
    }

    /**
     * Get the ID
     *
     * @return string
     */
    public function getId()
    {
        return data_get($this->response, 'shop.id');
    }

    /**
     * Get the shop name
     *
     * @return string
     */
    public function getShopName()
    {
        return data_get($this->response, 'shop.name');
    }

    /**
     * Get the MyShopify domain name
     *
     * @return string
     */
    public function getMyShopifyDomain()
    {
        return data_get($this->response, 'shop.myshopify_domain');
    }

    /**
     * Get the domain
     *
     * @return string
     */
    public function getDomain()
    {
        return data_get($this->response, 'shop.domain');
    }

    /**
     * Get the shopify plan
     *
     * @return string
     */
    public function getShopifyPlan()
    {
        return data_get($this->response, 'shop.plan_display_name');
    }

    /**
     * Get user data as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return data_get($this->response, 'shop');
    }
}