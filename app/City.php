<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function zipcodes()
    {
        // $this->hasMany(Zip::class, '');
    }
}
