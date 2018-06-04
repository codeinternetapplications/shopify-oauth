# Shopify Oauth connector

This packages enables you to make an OAuth connection with [Shopify](https://www.shopify.com/).

The package was originally written to use with [Lumen](https://lumen.laravel.com/). But it can also be used in combination with [Laravel](https://www.laravel.com/).
Note that since it was made for Lumen the connector is stateless.

# Installation

Use composer to install this package into your project
```
composer require codeinternetapplications/shopify-oauth
```


## Configuration

1. Copy the `shopify_oauth.php` config file to your config directory.
2. When using Lumen make sure you add the configuration in your `bootstrap/app.php` file
3. Set your `api_key` and `api_secret_key`. Also make sure you have configured the `scopes` properly.


## Usage

To start the OAuth handshake process with Shopify make sure you know what kind of access token you need. Shopify provides an `online` token and an `offline` token.
[Click here for more information on this](https://help.shopify.com/api/getting-started/authentication/oauth/api-access-modes).

Make sure your callback uri is whitelisted in the [Parners Dashboard](https://partners.shopify.com/) of Shopify.


```php

use CodeInternetApplications\ShopifyOauth\Client\ShopifyOauthClient;

...

// set the callback uri
$callback_uri = 'https://uri-to-the-callback-endpoint';

// put this on 'true' when you want to request an online token.
$use_online_mode = false;

// this will start the handshake with Shopify and redirects the user to Shopify for the grant request
(new ShopifyOauthClient($request->get('shop')))->initHandshake($callback_uri, $use_online_mode);
```

You can make an authentication request by navigation to the route where your authentication takes places.
Add this suffix to the url `?shop=<< URL of your shop >>`. You will have to make sure that the URL of your shop ends with `myshopify.com`.


Handling the callback is also easy

```php

use CodeInternetApplications\ShopifyOauth\Client\ShopifyOauthClient;

...

// oauth client
$client = new ShopifyOauthClient($request->get('shop'));

// this will return the token
$auth_code = $client->processCallback($request->get('code'));

```

You can additionally use these methods on the `ShopifyOauthClient` helper:
* getResourceOwner() : This will return the Shop information for the granted shop. You can use this method directly after handling the callback
* getAccessTokenValues() : This provides the additional values with the Token. For `online` access it will provide the associated user.
* getAccessToken() : This provides the token (string) that you can use as `X-Shopify-Access-Token` header.


## Middlewares

We have created 2 middlewares you can use to verify the validity or the requests.
* `ShopifyHostnameValidator`
* `ShopifyHmacValidator`

### ShopifyHostnameValidator
The `ShopifyHostnameValidator` middleware is used to verify the 'shop' parameter in incoming and outgoing requests.
It checks if:
* The requesting shop ends with `myshopify.com`
* The URL does only contain letters (a-z) and numbers (0-9), dots and hyphens


### ShopifyHmacValidator
The `ShopifyHmacValidator` middleware is specific for responses from Shopify. Note that this middleware will only work for this authorization request. It cannot be used to verify Webhook requests.



## ToDo
* Implement tests