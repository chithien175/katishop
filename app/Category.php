<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Get the categories for the category.
     */
    public function categories()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }
}
