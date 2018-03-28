<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'level',
    ];

    public $rules = [
      'name' => 'required|min:7',
      'email' => 'required|unique:users',
      'password' => 'required|min:8',
      'level' => 'required',
    ];

    // public $update_rules = [
    //   'name' => 'min:7',
    //   'email' => 'required|unique:users',
    //   // 'password' => 'required|min:8',
    //   // 'level' => 'required',
    //   // 'status' => 'required'
    // ];

    public static function update_rules($id, $merge=[]) {
    return array_merge(
        [
            'name'  => 'required|min:7',
            'email' => 'unique:users,email,'.$id,
            // 'password' => 'required|min:8',
            'level' => 'required',
            'status' => 'required'
        ], $merge);
  }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
