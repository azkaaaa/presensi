<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    protected $table = 'allowances';

    protected $fillable =
    [
      'name',
      'price'
    ];

    public $rules = [
      'name' => 'required|min:5',
      'price' => 'required'
    ];

}
