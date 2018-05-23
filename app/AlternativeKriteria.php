<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlternativeKriteria extends Model
{
    protected $table = 'talternatif_kriteria';

    protected $fillable =
    [
      'id_alternatif',
      'id_kriteria',
      'nilai'
    ];
}
