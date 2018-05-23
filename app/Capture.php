<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Capture extends Model
{
    protected $table = 'capture';

    protected $fillable =
    [
      'picture',
    ];

    public $rules = [
      'picture' => 'required',
    ];
}
