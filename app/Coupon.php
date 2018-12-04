<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'id', 'coupon_name', 'amount', 'amount_type', 'expiry_date', 'status', 'created_at',
    ];
}
