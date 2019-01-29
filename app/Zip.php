<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zip extends Model
{
    protected $fillable = [
      'ZIP_code',
      'City',
      'State',
      'Abbreviation',
      'Region',
    ];

    protected $table = 'zip';

    public $timestamps = false;

}
