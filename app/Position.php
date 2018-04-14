<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';

    protected $fillable =
    [
      'name',
      'salary',
      'transport',
      'user_id'
    ];

    public $rules = [
      'name' => 'required|min:5',
      'salary' => 'required',
      'transport' => 'required'
    ];

    public function user(){
      return $this->hasOne('App\User','user_id');
    }
}
