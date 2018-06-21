<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('con_shops', function (Blueprint $table) {

            // Store Details
            $table->unsignedBigInteger('id')->primary()->comment('Unique numeric identifier for the shop.'); // 690933842
            $table->string('name')->nullable()->comment('The name of the shop'); // "Apple Computers"
            $table->string('email')->nullable()->comment('The contact (account) email address for the shop.'); // "shopify@code.nl"
            $table->string('customer_email')->nullable()->comment('The contact (customer) email address for the shop.'); // "shopify@code.nl"

            // Domains
            $table->string('domain')->nullable()->comment('The shop\'s domain.'); // "shop.apple.com"
            $table->string('myshopify_domain')->nullable()->comment('The shop\'s \'myshopify.com\' domain.'); // "apple.myshopify.com"

            // Standards and formats
            $table->string('timezone')->nullable()->comment('The name of the timezone the shop is in.'); // "(GMT-05:00) Eastern Time"
            $table->string('iana_timezone')->nullable()->comment('The named timezone assigned by the IANA.'); // "America/New_York"
            $table->string('primary_locale')->nullable()->comment('The shop\'s primary locale.'); // "fr"
            $table->string('currency')->nullable()->comment('The three-letter code for the currency that the shop accepts.'); // "USD"
            $table->string('money_format')->nullable()->comment('A string representing the way currency is formatted when the currency isn\'t specified.'); // "$"
            $table->string('money_with_currency_format')->nullable()->comment('A string representing the way currency is formatted when the currency is specified.'); // "$ USD"
            $table->string('weight_unit')->nullable()->comment('A string representing the default unit of weight measurement for the shop.'); // "lb"

            // Plan
            $table->string('plan_name')->nullable()->comment('The name of the Shopify plan the shop is on.'); // "enterprise"
            $table->string('plan_display_name')->nullable()->comment('The display name of the Shopify plan the shop is on.'); // "enterprise"

            // Location
            $table->bigInteger('primary_location_id')->nullable()->comment('The primary location ID');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('con_shops');
    }
}
