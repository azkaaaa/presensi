<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $table = 'presences';

    protected $fillable =
    [
      'employee_id',
      'time_in',
      'time_out',
      'date',
      'shift',
      'info',
      'additional',
      'overtime',
      'overtime_status',
      'overtime_permit'
    ];

    public $rules = [
      'overtime' => 'required'
    ];

    public function employee(){
      return $this->belongsTo('App\Employee','employee_id');
    }
}
