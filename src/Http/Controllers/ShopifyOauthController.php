<?php

namespace CodeInternetApplications\ShopifyOauth\Http\Controllers;

use Carbon\Carbon;
use CodeInternetApplications\ShopifyOauth\Client\ShopifyOauthClient;
use CodeInternetApplications\ShopifyOauth\Exceptions\ShopifyOauthCallbackException;

use Illuminate\Http\Request;

use Laravel\Lumen\Routing\Controller as BaseController;

class ShopifyOauthController extends BaseController
{
    /**
     * Init the installation request
     *
     * @var Request $request
     */
    public function initInstallationRequest(Request $request)
    {
        // set the callback uri
        $callback_uri = route('shopify.oauth.callback', null, $https=true);

        return (new ShopifyOauthClient($request->get('shop')))->initHandshake($callback_uri);
    }

    /**
     * Handle the callback for the offline token
     *
     * @var Request $request
     */
    public function handleOauthCallback(Request $request)
    {
        // verify handshake
        try {
            $client = new ShopifyOauthClient($request->get('shop'));
            $client->processCallback($request->get('code'));

            // set shopify app uri
            $shopify_app_uri = 'https://'. $request->get('shop') .'/admin/apps/'. config('shopify_oauth.api_key');

            // okay, redirect the user to his store and the app so the online token is fixed as well (through the middleware)
            header('Location: '. $shopify_app_uri);
            exit;
        } catch (ShopifyOauthCallbackException $e) {
            throw new ShopifyOauthCallbackException('Something went wrong: '. $e->getMessage());
        }
    }
}
