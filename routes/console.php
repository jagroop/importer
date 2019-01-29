<?php

use Illuminate\Foundation\Inspiring;
use App\Zip;
use App\City;
use App\Imports\ZipImport;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/


Artisan::command('check', function () {
    $cities = City::query()->limit(10)->get();
    dd($cities);
})->describe('Display an inspiring quote');