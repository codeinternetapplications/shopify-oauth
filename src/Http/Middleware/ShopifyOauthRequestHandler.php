<?php

namespace CodeInternetApplications\ShopifyOauth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use CodeInternetApplications\ShopifyOauth\Client\ShopifyOauthClient;
use CodeInternetApplications\ShopifyOauth\Models\Shop;

/**
 * Shopify Oauth request handler
 *
 * Handles the Oauth request and stores the shop and token data into the database
 */
class ShopifyOauthRequestHandler
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
        // guard: check if the app is installed and a record exists in our systems
        if (!Shop::whereMyshopifyDomain($request->get('shop'))->first()) {
            return redirect()->route('shopify.oauth.authorize', $request->all()); // redirect to offline token oauth
        }
        // guard: check for the code, the other vars are handled by the other middlewares
        if (!$request->get('code')) {
            // get the app base url as callback url, make sure this url is whitelisted in the partner dashboard
            return (new ShopifyOauthClient($request->get('shop')))->initHandshake(config('shopify_oauth.base_url'), true);
        }

        // Init client
        $client = new ShopifyOauthClient($request->get('shop'));

        // check for token
        if (!$token = $client->processCallback($request->get('code'))) {
            return response('Something went wrong while verifying. Please try again.', 500);
        }

        return $next($request);
    }
}
