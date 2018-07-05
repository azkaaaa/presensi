<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    protected $table = 'talternatif';
    protected $fillable = ['id_alternatif', 'nama_alternatif', 'deskripsi'];

    public $rules = [
      'id_alternatif' => 'required',
      'nama_alternatif' => 'required',
      'deskripsi' => 'required',
    ];
}
