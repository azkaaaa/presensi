<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlternativeKriteria extends Model
{
    protected $table = 'talternatif_kriteria';
    protected $fillable = ['id_alternatif_kriteria', 'id_alternatif', 'id_kriteria', 'nilai'];

    public $rules = [
      'id_alternatif_kriteria' => 'required',
      'id_alternatif' => 'required',
      'id_kriteria' => 'required',
      'nilai' => 'required',
    ];
}
