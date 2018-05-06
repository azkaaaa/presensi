<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    protected $table = 'months';

    protected $fillable =
    [
      'name'
    ];

    public $rules = [
      'name' => 'required|min:3'
    ];
}
