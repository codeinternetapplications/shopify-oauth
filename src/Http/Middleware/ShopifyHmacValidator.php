<?php

namespace CodeInternetApplications\ShopifyOauth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ShopifyHmacValidator
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
        // guard: check for the hmac param
        if (!$hmac_param = $request->query('hmac')) {
            return response('Bad request, hmac parameter not found', 400);
        }
        // check hmac
        if (!$this->isValidHmac($request)) {
            return response('Forbidden, invalid HMAC', 403);
        }

        return $next($request);
    }

    /**
     * Validates a URL request originates from Shopify
     * using hmac in query string
     *
     * @param Request $request
     * @return bool
     */
    private function isValidHmac(Request $request) : bool
    {
        return hash_equals($request->query('hmac'), $this->generateHmacFromQuery($request));
    }

    /**
     * Generate our hmac from the request query string
     *
     * @param Request $request
     * @return string
     */
    private function generateHmacFromQuery(Request $request): string
    {
        // build the http query string
        $httpQuery = http_build_query($request->except('_url', 'hmac'));

        // urldecode to make sure that elements like protocols are not encoded the hmac check wil fail on that
        $httpQuery = urldecode($httpQuery);

        return hash_hmac('sha256', $httpQuery, config('shopify_oauth.api_secret_key'));
    }
}
