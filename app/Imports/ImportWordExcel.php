<?php

namespace App\Imports;

use App\Models\ImportExcelWord;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportWordExcel implements ToModel
{
    public function model(array $row)
    {
        // return new ImportExcelWord([
        //     'test_id' => $row[0],
        //     'importvalue' => $row[1],
        //     'filename' => $row[2],
        // ]);
    }
}
