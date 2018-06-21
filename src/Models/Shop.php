<?php

namespace CodeInternetApplications\ShopifyOauth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Shop extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'con_shops';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // Store Details
        'id',
        'name',
        'email',
        'customer_email',

        // Domains
        'domain',
        'myshopify_domain',

        // Standards and formats
        'timezone',
        'iana_timezone',
        'primary_locale',
        'currency',
        'money_format',
        'money_with_currency_format',
        'weight_unit',

        // Plan
        'plan_name',
        'plan_display_name',

        // Location
        'primary_location_id',
    ];


    /**
     * Get the Access tokens of this shop
     */
    public function access_tokens()
    {
        return $this->hasMany('CodeInternetApplications\ShopifyOauth\Models\ShopAccessToken');
    }
}
