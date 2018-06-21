<?php

namespace CodeInternetApplications\ShopifyOauth\Http\Middleware;

use Closure;

class ShopifyHostnameValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // guard: check only if we are in production
        if (env('APP_ENV') != 'production') {
            return $next($request);
        }
        // guard
        if (!$shop_uri = $request->query('shop')) {
            return response('Bad request, please provide the Shop parameter', 400);
        }
        // guard: check the shopify URL
        if (!$this->isShopifyRequest($shop_uri)) {
            return response('Forbidden, the URL provided is not a valid Shopify URL', 403);
        }
        // guard: ensure it not contain characters other than letters (a-z), numbers (0-9), dots, and hyphens
        if (!$this->isValidRequest($shop_uri)) {
            return response('Forbidden, the URL contains forbidden characters', 403);
        }

        return $next($request);
    }

    /**
     * Ensure the provided hostname parameter is a valid hostname, ends with myshopify.com
     * Make sure the request comes from Shopify
     *
     * @return boolean TRUE | FALSE
     */
    private function isShopifyRequest($shop_uri)
    {
        // guard: match hostname
        if (!preg_match('/[^.]+\.[^.]+$/', $shop_uri, $matches)) {
            return FALSE;
        }
        // guard: get host
        if (!$host_name = $matches[0]) {
            return FALSE;
        }

        // ensure the host name ends with myshopify.com
        return (bool) ($host_name === 'myshopify.com');
    }

    /**
     * Ensure the provided hostname parameter is a valid hostname, ends with myshopify.com
     * Make sure the request comes from Shopify
     *
     * @return boolean TRUE | FALSE
     */
    private function isValidRequest($shop_uri)
    {
        // guard: check
        if (!preg_match('/^[a-zA-Z\\-.]+$/', $shop_uri, $matches)) {
            return FALSE;
        }
        // guard: get the validated shop
        if (!$validated_host_name = $matches[0]) {
            return FALSE;
        }

        // ensure that match[0] is exactly the name of the shop
        return (bool) ($validated_host_name === $shop_uri);
    }
}
