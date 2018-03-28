<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable =
    [
      'name',
      'nik',
      'id_card',
      'birthday',
      'religion',
      'address',
      'phone',
      'education',
      'account_number',
      'position_id',
      'user_id'
    ];

    public $rules = [
      'name' => 'required|min:5',
      'nik' => 'required|min:16|max:16|unique:employees',
      'id_card' => 'required|unique:employees',
      'birthday' => 'required',
      'religion' => 'required',
      'address' => 'required',
      'phone' => 'required|numeric|unique:employees',
      'education' => 'required',
      'account_number' => 'required|numeric|min:10|unique:employees'
      // 'status' => 'required'
    ];

    public $update_rules = [
      'name' => 'min:5',
      'nik' => 'min:16|max:16|unique:employees',
      'id_card' => 'unique:employees',
      // 'birthday' => 'required',
      // 'religion' => 'required',
      // 'address' => 'required',
      'phone' => 'numeric|unique:employees',
      // 'education' => 'required',
      'account_number' => 'numeric|min:10|unique:employees'
      // 'status' => 'required'
    ];

    public static function update_rules($id=0, $merge=[]) {
    return array_merge(
        [
            'name' => 'required|min:5',
            'nik' => 'required|min:16|max:16|unique:employees,nik,'.$id,
            'id_card' => 'required|unique:employees,id_card,'.$id,
            'birthday' => 'required',
            'religion' => 'required',
            'address' => 'required',
            'phone' => 'required|numeric|unique:employees,phone,'.$id,
            'education' => 'required',
            'account_number' => 'required|numeric|min:10|unique:employees,account_number,'.$id
        ], $merge);
  }

    public function user(){
      return $this->belongsTo('App\User','user_id');
    }
    public function position(){
      return $this->hasOne('App\Position','position_id');
    }
}
