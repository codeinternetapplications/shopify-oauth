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

We tried to make it as easy as possible. Perform these steps to start:

### Copy config file
Copy the `shopify_oauth.php` config file to your config directory and make it available in the `bootstrap/app.php` file.

### Adjust your keys in the config
Set your `api_key`, `api_secret_key` and `base_url`. Also adjust your `scopes`. You can use the `.env` file for this (see below)

### Make sure your app supports Facades and Eloquent
In Lumen you will have to uncomment these lines in `bootstrap/app.php`:
```php
// $app->withFacades();

// $app->withEloquent();
```

#### Environment file
Put these variables in your `.env` file:

```
SHOPIFY_APP_BASE_URL=https://url-to-your-app/
SHOPIFY_OAUTH_API_KEY=<API key obtained from the partner dashboard>
SHOPIFY_OAUTH_SECRET_KEY=<API Secret key obtained from the partner dashboard>
```

Also make sure that your `APP_KEY` is defined. Since we encrypt some data in the database Lumen/Laravel needs this key to encrypt it.

### Register the ShopifyOauthServiceProvider
Register the `ShopifyOauthServiceProvider` in your application.


### Run migrations
Run the migrations so you get the `con_shops` and `con_shop_access_tokens` table.
```
php artisan migrate
```


## Usage of Middleware

Make sure that when you want to use the `online token` you will have to add the Middleware `shopify-oauth-handler`.
It is advisable to use these middlewares in your routes:
* shopify-hostname-validation
* shopify-hmac-validation
* shopify-oauth-handler

For example:
```php

$router->group([
    'middleware'    => [
        'shopify-hostname-validation',
        'shopify-hmac-validation',
        'shopify-oauth-handler',
    ]
], function() use ($router) {

    // Redirect to Polaris view
    $router->addRoute(['GET','POST','PUT'], '/[{page}]', function () {
        return view('polaris');
    });
});
```

## Execute scripts after installation
To install webhooks or trigger something right after the installation of the application you will have to implement an event listener into your app.

When the App is installed an event is triggered. You can listen to this event and implement custom actions such as:
- Install webhooks
- Trigger some data imports

### Create listener and listen
Open your `bootstrap/app.php` file and make sure that the `EventServiceProvider` is enabled.

Open the `EventServiceProvider.php` file and add these lines:

```php
    protected $listen = [
        'CodeInternetApplications\ShopifyOauth\Events\PostShopifyCallbackEvent' => [
            'App\Listeners\PostShopifyCallbackListener',  // assuming that your listener is located at App\Listeners\PostShopifyCallbackListener
        ],
    ];
```

Create a new local listener in your `app/Listeners` folder and add the scripts you want to perform. You can start with this template:

```php
<?php

namespace App\Listeners;

use CodeInternetApplications\ShopifyOauth\Events\PostShopifyCallbackEvent;

class PostShopifyCallbackListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostShopifyCallbackEvent  $event
     * @return void
     */
    public function handle(PostShopifyCallbackEvent $event)
    {
        // log
        \Log::channel('stack')->info('PostShopifyCallbackEvent is triggered', []);
    }
}


```