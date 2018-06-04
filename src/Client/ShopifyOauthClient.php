<?php

namespace CodeInternetApplications\ShopifyOauth\Client;

use GuzzleHttp\Client;
use CodeInternetApplications\ShopifyOauth\Client\Provider\ShopifyProvider;
use CodeInternetApplications\ShopifyOauth\Exceptions\ShopifyOauthCallbackException;
use Illuminate\Http\Request;

/**
 * Shopify Oauth 2.0 Client
 *
 * @return void
 */
class ShopifyOauthClient
{
    /**
     * Shop URI
     * @param string
     */
    protected $shop;

    /**
     * Access token
     * @param string
     */
    private $access_token;

    /**
     * Provider
     * @param object
     */
    private $provider;

    /**
     * Constructor
     *
     * @param $shop Shopify URI
     */
    public function __construct($shop)
    {
        // to be sure, lowercase it
        $this->shop = strtolower($shop);
    }

	/**
	 * Init the OAuth handshake for Shopify
	 *
     * @param string redirect uri
     * @param boolean online access mode (optional, FALSE by default so offline access mode is used)
	 * @return void
	 */
	public function initHandshake($redirect_uri, $online_access_mode=FALSE)
	{
        // set options (these will be appended to the default options)
        $option_arr = [
		    'redirectUri'   => $redirect_uri
        ];

        // append extra option value when online access is requested
        $extra_option_arr = [];
        if ($online_access_mode === TRUE) {
            $extra_option_arr['grant_options[]'] = 'per-user';
        }

        // set provider
        $provider = $this->getShopifyOauth2Provider($option_arr);

		// redirect the user to the authentication screen of Shopify
		header('Location: '. $provider->getAuthorizationUrl($extra_option_arr));
		exit;
	}

    /**
     * Process callback for app
     *
     * @param string response code
     * @return string Authorization code (online / offline)
     */
    public function processCallback($auth_code)
    {
        try {
            // set additional options
            $addional_option_arr = [];

             // get provider
            $provider = $this->getShopifyOauth2Provider();

            // obtain the access token
            $this->access_token = $provider->getAccessToken('authorization_code', ['code' => $auth_code]);
        } catch (\Exception $e) {
            throw new ShopifyOauthCallbackException('Something went wrong: '. $e->getMessage());
        }

        return $this->access_token->getToken();
    }

    /**
     * Get the resource owner
     *
     * @return ShopifyResource
     */
    public function getResourceOwner()
    {
        // guard
        if (!$this->access_token) {
            return;
        }

        try {
            // get the provider
            $provider = $this->getShopifyOauth2Provider();

            // set resource owner
            $resource_owner = $provider->getResourceOwner($this->access_token);
        } catch (\Exception $e) {
            throw new ShopifyOauthCallbackException('Something went wrong: '. $e->getMessage());
        }

        // return the resource owner
        return $resource_owner;
    }

    /**
     * Get the access token values
     * To obtain the associated user data and the scopes
     *
     * @return array
     */
    public function getAccessTokenValues()
    {
        return $this->access_token->getValues();
    }

    /**
     * Get the access token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token->getToken();
    }

	/**
	 * Verify the the hostnane, must end with .myshopify.com
	 *
	 * @param string shop uri
	 * @param array options
	 * @return ShopifyProvider
	 */
	private function getShopifyOauth2Provider($addional_option_arr=[])
	{
        // guard
        if (!is_null($this->provider)) {
            return $this->provider;
        }

		// set basic options
		$options = [
		    'clientId'      => config('shopify_oauth.api_key'),
		    'clientSecret'  => config('shopify_oauth.api_secret_key'),
		    'shop'			=> $this->shop,
		];

        // merge options
        $options = array_merge($options, $addional_option_arr);

        // set provider
        $this->provider = new ShopifyProvider($options);

		// create oauth2
		return $this->provider;
	}

    /**
     * Get an error response
     *
     * @param integer $code HTTP Response code
     * @param string $message HTTP Response message
     * @return response
     */
    protected function getErrorResponse($http_response_code, $message)
    {
        return response()->json(
            [
                'code'      => $http_response_code,
                'message'   => $message,
            ],
            $http_response_code
        );
    }
}
