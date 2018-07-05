<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable =
    [
      'transaction_no',
      'total_price',
      'customer_id',
      'status',
      'order_date',
    ];

    public $rules = [
      'transaction_no' => 'required',
      'total_price' => 'required',
      'customer_id' => 'required',
      'status' => 'required',
      'order_date' => 'required',
    ];
}
