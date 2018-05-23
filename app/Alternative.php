<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    protected $table = 'talternatif';

    protected $fillable =
    [
      'nama_alternatif',
      'deskripsi'
    ];
}
