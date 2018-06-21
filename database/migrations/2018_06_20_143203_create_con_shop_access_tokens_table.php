<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConShopAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('con_shop_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Token data
            $table->string('access_token')->nullable()->comment('The access token that can be used in requests with Shopify (X-Shopify-Access-Token header)');
            $table->text('scope')->nullable()->comment('The scopes where the token is valid for');

            // Associated user information (Online token only)
            $table->text('associated_user_scope')->nullable()->comment('Online token only: List of access scopes that were granted to the application and are available for this access token, given the users permissions');
            $table->bigInteger('associated_user_id')->nullable()->comment('Online token only: contains the ID of the admin user who went through the OAuth2 authorization flow');
            $table->boolean('associated_user_account_owner')->default(false)->comment('Online token only: Flag that determines whether the admin user is the account owner or not');

            // Timestamps
            $table->timestamp('token_expire_date')->nullable()->comment('Online token only: The date and time when the online token will expire');
            $table->timestamps();

            // Shop
            $table->unsignedBigInteger('shop_id')->comment('The Shopify Shop Identifier.'); // 433979449
            $table->foreign('shop_id')->references('id')->on('con_shops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('con_shop_access_tokens');
    }
}
