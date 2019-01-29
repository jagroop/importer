<?php

namespace App\Imports;

use App\Zip;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class ZipImport implements ToModel, WithProgressBar
{
    
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Zip([
            'ZIP_code' => $row[0],
            'City' => $row[1],
            'State' => $row[2],
            'Abbreviation' => $row[3],
            'Region' => $row[4],
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
