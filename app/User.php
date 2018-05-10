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

    public function employee_detail(){
      return $this->hasOne('App\Employee','id');
    }

    public function employee(){
    return $this->hasOne(Employee::class);
    }

    public function hasRole($role)
    {
    return User::where('level', $role)->get();
    }
}
