<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Get the category for the product.
     */
    public function categories()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    /**
     * Get the attributes for the product.
     */
    public function attributes()
    {
        return $this->hasMany('App\ProductAttribute', 'product_id');
    }

    /**
     * Get the attributes for the product.
     */
    public function galleries()
    {
        return $this->hasMany('App\ProductGallery', 'product_id');
    }
}
