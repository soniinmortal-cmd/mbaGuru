<?php

namespace App\Imports;

use App\Models\Admin\Student;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class Excel implements 
ToModel,
WithHeadingRow,
SkipsOnError,
WithValidation,
SkipsOnFailure
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            'name' => $row['name'],
            'email' => $row['email'],
            'mobile' => $row['mobile'],
        ]);
    }

    public function onError(Throwable $error)
    {
        
    }

    public function rules(): array
    {
        return [
            '*.name' => ['required', 'string', 'max:100'],
            '*.mobile' => ['required', 'alpha_num', 'max:20'],
            '*.email' => ['required', 'string', 'email', 'max:255', 'unique:students,email']
        ];
    }

    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures) {

    }
    
}
