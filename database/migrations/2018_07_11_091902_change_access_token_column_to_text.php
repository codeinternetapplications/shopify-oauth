<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAccessTokenColumnToText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('con_shop_access_tokens', function (Blueprint $table) {
            $table->text('access_token')->nullable()->change()->comment('The encrypted access token that can be used in requests with Shopify (X-Shopify-Access-Token header)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('con_shop_access_tokens', function (Blueprint $table) {
            $table->string('access_token')->nullable()->change()->comment('The access token that can be used in requests with Shopify (X-Shopify-Access-Token header)');
        });
    }
}
