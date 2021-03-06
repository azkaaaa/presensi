<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $table = 'days';

    protected $fillable =
    [
      'name'
    ];

    public $rules = [
      'name' => 'required|min:3'
    ];
}
