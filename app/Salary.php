<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salaries';

    protected $fillable =
    [
      'employee_id',
      'salary',
      'total_allowance',
      'total_overtime',
      'total_salary'
    ];

    // public $rules = [
    //   'name' => 'required|min:5',
    //   'salary' => 'required'
    // ];

    public function employee(){
      return $this->hasOne('App\Employee','employee_id');
    }
}
