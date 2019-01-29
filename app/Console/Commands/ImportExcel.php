<?php

namespace App\Console\Commands;

use App\Imports\UsersImport;
use Illuminate\Console\Command;
use Excel;
use App\Imports\ZipImport;

class ImportExcel extends Command
{
    protected $signature = 'import:excel';

    protected $description = 'Laravel Excel importer';

    public function handle()
    {
        $this->output->title('Starting import');
        (new ZipImport)->withOutput($this->output)->import('cities.xlsx');
        $this->output->success('Import successful');
    }
}