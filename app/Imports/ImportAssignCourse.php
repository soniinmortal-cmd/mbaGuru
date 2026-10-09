<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
// use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use DB;
//use Maatwebsite\Excel\Concerns\ToModel;

class ImportAssignCourse implements ToCollection, WithHeadingRow, WithChunkReading, WithValidation
{
    use Importable;

     /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $errors;

    public function collection(Collection $rows)
    {
        $this->errors = collect();
        $i=1; 
        foreach ($rows as $row) 
        { 
            $existingUser = DB::table('assign_test')
                                ->where('email',$row['email'])
                                ->where('course_id',$row['course_id'])
                                ->where('status',1)
                                ->first();
            if ($existingUser) {
                    $this->errors->push("Already Assign!!");
                    continue;
            }else{
                if($row->filter()->isNotEmpty()){
                    $values = array(
                    'email' => $row['email'],
                    'course_id' => $row['course_id'],
                    'status' => $row['status'],
                    );
                    DB::table('assign_test')->insert($values); 
                }

            }
          $i++;  
        }
    }



     public function chunkSize(): int
    {
        return 100;
    }

    public function rules(): array
    {
        return[
      //     'email' => 'unique:assign_test',
        ];
    }


    public function getErrors()
    {
        return $this->errors;
    }
}
