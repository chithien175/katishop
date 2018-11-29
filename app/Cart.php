<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * Get the product for the cart.
     */
    public function products()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    /**
     * Get the attributes for the cart.
     */
    public function attributes()
    {
        return $this->belongsTo('App\ProductAttribute', 'attribute_id');
    }
}
