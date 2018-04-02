<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $table = 'presences';

    protected $fillable =
    [
      'employee_id',
      'time',
      'date',
      'shift',
      'info',
      'additional'
    ];

    // public $rules = [
    //   'name' => 'required|min:5',
    //   'salary' => 'required'
    // ];

    public function employee(){
      return $this->hasOne('App\Employee','employee_id');
    }
}
