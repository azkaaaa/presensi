<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'tkriteria';
    public $primaryKey  = 'id_kriteria';
    protected $fillable = ['id_kriteria','nama_kriteria','kepentingan', 'costbenefit'];

    public $rules = [
      'id_kriteria' => 'required',
      'nama_kriteria' => 'required',
      'kepentingan' => 'required',
      'costbenefit' => 'required',
    ];
}
