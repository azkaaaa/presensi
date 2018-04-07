<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAllowance extends Model
{
    protected $table = 'employee_allowances';

    protected $fillable =
    [
      'employee_id',
      'allowance_id'
    ];

    public $rules = [
      'employee_id' => 'required',
      'allowance_id' => 'required'
    ];

    public function employee(){
      return $this->belongsTo('App\Employee','employee_id');
    }

    public function allowance(){
      return $this->belongsTo('App\Allowance','allowance_id');
    }
}
