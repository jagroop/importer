<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Zip;
use DB;
class SyncZipcodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zip:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $limit = 5000;
      $offset = 0;
      $this->output->title('-- Starting syncing');
         $cities = DB::table('cities')->select('cities.*', 'states.name as state_name')->leftJoin('states', 'cities.state_id', '=', 'states.id')->limit($limit)->offset($offset)->get();
        $bar = $this->output->createProgressBar(count($cities));
        $bar->start();
          $zipcodesData = [];
          foreach ($cities as $d => $city) {
            $cityId = $city->id;
            $zcodes = Zip::where('City', $city->name)->where('State', $city->state_name)->get()->map(function($item) use($cityId){
              return [
                'city_id' => $cityId,
                'zip_code' => $item->ZIP_code,
              ];
            })->all();
            $zipcodesData[$d] = $zcodes;
            $bar->advance();
          }

          $zipcodesDataArr = collect($zipcodesData)->flatten(1)->all();

          DB::table('zip_codes')->insert($zipcodesDataArr);
          $bar->finish();
          $this->output->success('-- Syncing successful');
    }
}
