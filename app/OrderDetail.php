<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_detail';
    protected $fillable = ['order_id', 'menu_id', 'qty', 'subtotal'];

    public $rules = [
      'order_id' => 'required',
      'menu_id' => 'required',
      'qty' => 'required',
      'subtotal' => 'required',
    ];
}
