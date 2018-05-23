<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'tkriteria';

    protected $fillable =
    [
      'nama_kriteria',
      'kepentingan',
      'costbenefit'
    ];
}
