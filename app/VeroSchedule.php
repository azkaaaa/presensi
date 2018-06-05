<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VeroSchedule extends Model
{
    protected $table = 'vero_schedule';

    protected $fillable =
    [
      'employee_id',
      'first_week',
      'second_week',
      'third_week',
      'fourth_week'
    ];

    // public $rules = [
    //   'shift' => 'required',
    //   'date' => 'required'
    // ];

    public function employee(){
      return $this->belongsTo('App\Employee','employee_id');
    }
}
