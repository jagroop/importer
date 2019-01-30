<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function scopeZipcodes($query)
    {
        // $query->leftJoin('zip', 'zip.City', '=', 'cities.name')->leftJoin('states', 'states.');
        return $query->leftJoin('states', 'states.id', '=', 'cities.state_id')->leftJoin('zip', function($join){
          return $join->on('states.name', '=', 'zip.State')->on('cities.name', '=', 'zip.City');
        });
    }
}
