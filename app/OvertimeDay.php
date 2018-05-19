<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OvertimeDay extends Model
{
    protected $table = 'overtime_days';

    protected $fillable =
    [
      'name'
    ];

    public $rules = [
      'name' => 'required|min:3'
    ];
}
