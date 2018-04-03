<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Capture extends Model
{
    protected $table = 'capture';

    protected $fillable =
    [
      'namafoto'
    ];

    public $rules = [
      'namafoto' => 'required'
    ];
}
