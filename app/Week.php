<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $table = 'weeks';

    protected $fillable =
    [
      'name'
    ];

    public $rules = [
      'name' => 'required|min:3'
    ];
}
