<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Zip;
use DB;
class Foo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
    public function _handle()
    {
      $this->output->title('-- Starting syncing');
      $states = DB::table('states')->get();
      $bar = $this->output->createProgressBar(count($states));
      $bar->start();
      foreach($states as $key => $state) {
        Zip::where('State', $state->name)->update(['state_id' => $state->id]);
        $bar->advance();
      }
      $bar->finish();
      $this->output->success('-- Syncing successful');
    }

    public function handle()
    {
      $this->output->title('-- Starting cities syncing');
      $cities = DB::table('cities')->limit(5000)->offset(5000)->get();
      $bar = $this->output->createProgressBar(count($cities));
      $bar->start();
      $response = [];
      foreach($cities as $key => $city) {
        $response[$key]['City'] = $city->name;
        $response[$key]['city_id'] = $city->id;
        $bar->advance();
      }
      Zip::custom_batch_update('zip', 'City', $response);
      $bar->finish();
      $this->output->success('-- Syncing successful');
    }
}
