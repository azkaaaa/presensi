<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = ['name', 'price', 'type', 'status', 'desc', 'picture'];

    public $rules = [
      'name' => 'required|min:5',
      'type' => 'required',
      'status' => 'required',
      'desc' => 'required',
      'price' => 'required'

    ];
}
