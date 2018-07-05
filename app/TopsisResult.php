<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopsisResult extends Model
{
    protected $table = 'topsis_result';

    protected $fillable =
    [
      'id',
      'employee_id',
      'value',
      'month',
      'year',
    ];
}
