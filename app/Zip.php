<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    public static function custom_batch_update($table_name = '', $key = '', $update_arr = array()) {

    if(!$table_name || !$key || !$update_arr){
        return false;
    }

    $update_keys = array_keys($update_arr[0]);
    $update_keys_count = count($update_keys);

    for ($i = 0; $i < $update_keys_count; $i++) {
        $key_name = $update_keys[$i];
        if($key === $key_name){
            continue;
        }
        $when_{$key_name} = $key_name . ' = CASE';
    }

    $length = count($update_arr);
    $index = 0;
    $query_str = 'UPDATE ' . $table_name . ' SET ';
    $when_str = '';
    $where_str = ' WHERE ' . $key . ' IN(';

    while ($index < $length) {
        $when_str = " WHEN $key = '{$update_arr[$index][$key]}' THEN";
        $where_str .= "'{$update_arr[$index][$key]}',";
        for ($i = 0; $i < $update_keys_count; $i++) {
            $key_name = $update_keys[$i];
            if($key === $key_name){
                continue;
            }
            $when_{$key_name} .= $when_str . " '{$update_arr[$index][$key_name]}'";
        }
        $index++;
    }

    for ($i = 0; $i < $update_keys_count; $i++) {
        $key_name = $update_keys[$i];
        if($key === $key_name){
            continue;
        }
        $when_{$key_name} .= ' ELSE ' . $key_name . ' END, ';
        $query_str .= $when_{$key_name};
    }
    $query_str = rtrim($query_str, ', ');
    $where_str = rtrim($where_str, ',') . ')';
    $query_str .= $where_str;
    $affected = DB::update($query_str);

    return $affected;
  }
}
