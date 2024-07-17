<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionPaymentDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'manager_id',   'division_id',  'customer_name', 'address1', 'address2', 'address3', 'city', 'state', 'country', 'amount', 'status',    'token', 'worldpay_ordercode',

    ];
}
