<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    protected $fillable =
    [
      'employee_id',
      'shift',
      'day',
      'date',
      'status'
    ];

    // public $rules = [
    //   'shift' => 'required',
    //   'date' => 'required'
    // ];

    public function employee(){
      return $this->belongsTo('App\Employee','employee_id');
    }
}
