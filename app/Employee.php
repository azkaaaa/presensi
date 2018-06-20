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
      'address',
      'phone',
      'account_number',
      'profile_picture',
      'position_id',
      'user_id'
    ];

    public $rules = [
      'name' => 'required|min:5',
      'nik' => 'required|min:16|max:16|unique:employees',
      'id_card' => 'required|unique:employees',
      'birthday' => 'required',
      'address' => 'required',
      'phone' => 'required|numeric|unique:employees',
      'account_number' => 'required|numeric|min:10|unique:employees'
      // 'status' => 'required'
    ];

    public static function update_rules($id=0, $merge=[]) {
    return array_merge(
        [
            'name' => 'required|min:5',
            'nik' => 'required|min:16|max:16|unique:employees,nik,'.$id,
            'id_card' => 'required|unique:employees,id_card,'.$id,
            'birthday' => 'required',
            'address' => 'required',
            'phone' => 'required|numeric|unique:employees,phone,'.$id,
            'account_number' => 'required|numeric|min:10|unique:employees,account_number,'.$id
        ], $merge);
  }

    public function user(){
      return $this->belongsTo('App\User','user_id');
    }
    public function position(){
      return $this->belongsTo('App\Position','position_id');
    }

    public function user_detail(){
      return $this->belongsTo(User::class);
    }
}
