<?php

namespace CodeInternetApplications\ShopifyOauth\Traits;

use Illuminate\Support\Facades\Crypt;

trait Encrypter
{
    /**
     * Set an attribute
     *
     * @param string field name
     * @param string value
     * @return void
     */
    public function setAttribute($field, $value) {
        // guard
        if (!property_exists(__CLASS__, 'encrypted_fields')) {
            return parent::setAttribute($field, $value);
        }
        // guard
        if (is_null($this->encrypted_fields)) {
            return parent::setAttribute($field, $value);
        }
        // check if the field is an encrypted one
        if (!in_array($field, $this->encrypted_fields)) {
            return parent::setAttribute($field, $value);
        }

        // set
        $this->attributes[$field] = Crypt::encryptString($value);
    }

    /**
     * Get an attribute
     *
     * @param string field name
     * @return void
     */
    public function getAttribute($field) {
        if (!property_exists(__CLASS__, 'encrypted_fields')) {
            return parent::getAttribute($field);
        }
        // guard
        if (is_null($this->encrypted_fields)) {
            return parent::getAttribute($field);
        }
        // check if the field is an encrypted one
        if (!in_array($field, $this->encrypted_fields)) {
            return parent::getAttribute($field);
        }

        return Crypt::decryptString($this->attributes[$field]);
    }
}
