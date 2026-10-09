<?php

namespace App\Imports;

use App\Models\Percentile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
// use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use DB;
//use Maatwebsite\Excel\Concerns\ToModel;

class PercentileImport implements ToCollection, WithHeadingRow, WithChunkReading, WithValidation
{
    use Importable;

     /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

  // public function model(array $row)
    // {
    //     if(!array_filter($row)) {
    //         return null;
    //     } 
    //     print_r($row);
    //     die;
    //     return new Percentile([
    //         'score'     => $row['0'],
    //         'percentile'     => $row['1'],
    //         'section_type'    => $row['2']
    //     ]);
    // }

    public function collection(Collection $rows)
    {

            $record = DB::table('percentiles')
                    //  ->where('score',$row['score'])
                    //   ->where('section_type', $row['section_type'])
                        ->get();
                
        foreach ($rows as $row) {
                      if($row->filter()->isNotEmpty()){
                         // dd($row);
                            $values = array(
                            'score' => $row['score'],
                            'percentile' => $row['percentile'],
                            'section_type' => $row['section_type'],
                            'test_id'=> $row['test_id'],
                            );
                            DB::table('percentiles')->insert($values); 
                        }
                    
        }

        
    }
    
//     public function collection(Collection $rows)
// {
//     // Fetch existing records from the 'percentiles' table
//     $records = DB::table('percentiles')->get();

//     foreach ($rows as $row) {
//         if ($row->filter()->isNotEmpty()) {
//             // Check if the row is an array or an object
//             if (is_array($row)) {
              
//                 $score = isset($row['score']) ? $row['score'] : null;
//                 $percentile = isset($row['percentile']) ? $row['percentile'] : null;
//                 $section_type = isset($row['section_type']) ? $row['section_type'] : null;
//                 $test_id = isset($row['test_id']) ? $row['test_id'] : null;
//             } elseif (is_object($row)) {
             
//                 $score = isset($row->score) ? $row->score : null;
//                 $percentile = isset($row->percentile) ? $row->percentile : null;
//                 $section_type = isset($row->section_type) ? $row->section_type : null;
//                 $test_id = isset($row->test_id) ? $row->test_id : null;
//             }

//             // Ensure all necessary data is available before inserting
//             if ($score !== null && $percentile !== null && $section_type !== null && $test_id !== null) {
               
//                 $values = array(
//                     'score' => $score,
//                     'percentile' => $percentile,
//                     'section_type' => $section_type,
//                     'test_id' => $test_id,
//                 );
//                 DB::table('percentiles')->insert($values); 
//             }
//         }
//     }
// }




     public function chunkSize(): int
    {
        return 100;
    }

    public function rules(): array
    {
        return[
      //     'score' => 'unique:percentiles',
        ];
    }


    
}
