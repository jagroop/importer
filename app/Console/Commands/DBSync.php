<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Zip;
use DB;

class DBSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sync';

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
        $this->output->title('Starting syncing');

        $countryId = 233;
        $states = Zip::groupBy('State')->get();
        $bar = $this->output->createProgressBar(count($states));
        $bar->start();
        foreach ($states as $key => $state) {
          
          $insertState = DB::table('states')->insert([
            'name'       => $state->State,
            'country_id' => $countryId,
            'abbrv'      => $state->Abbreviation
          ]);

          $stateId = DB::getPdo()->lastInsertId();
          
          $cities = Zip::where('State', $state->State)->groupBy('City')->get();

          $insertCityData = [];

          foreach ($cities as $f => $city) {
            $insertCityData[$f] = [
              'name'       => $city->City,
              'state_id'   => $stateId,
              'country_id' => $countryId,
              'region'     => $city->Region,
            ];
          }

          DB::table('cities')->insert($insertCityData);          

          $bar->advance();
        }
        $bar->finish();
        $this->output->success('Syncing successful');
    }
}
