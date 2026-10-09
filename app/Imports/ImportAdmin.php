<?php

namespace App\Imports;

use App\Models\Studentlog;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
// use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use DB;
// use Illuminate\Support\Facades\Validator;

class ImportAdmin implements ToCollection, WithHeadingRow, WithChunkReading, WithValidation
{
    use Importable;


    public function __construct(){
       
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function collection(Collection $rows)
    // {
      
    //     foreach ($rows as $row) {
          
    //         if (Studentlog::where('email', $row['email'])->exists()) {
    //             // Log debug message
    //             \Log::debug("Skipping row with email {$row['email']} as it already exists.");
    //             continue; // Skip this row and continue with the next
    //         }
    //         $user = DB::table('studentlogs')->insert([

    //             'name' => $row['name'],
    //             'email' => $row['email'],
    //             'password' => Hash::make($row['password']),
    //             'show_password' => $row['password'],
    //             'mobile' => $row['mobile'],
    //             'centercode' => $row['centercode'],
    //             'batch_code' => $row['batch_code'],
    //             'catyear' => $row['catyear'],
    //             'admissiondate' => $row['admissiondate'],
    //             'dateofbirth' => $row['dateofbirth'],
    //             'address' => $row['address'],
    //             'college' => $row['college'],
              
          
    //         ]);
    //     }


    // }


//     public function collection(Collection $rows)
// {
//     foreach ($rows as $row) {
//         // Check if the email already exists in the database
//         if (Studentlog::where('email', $row['email'])->exists()) {
//             continue; // Skip this row and continue with the next
//         }

//         // Insert the row into the database
//         $user = DB::table('studentlogs')->insert([
//             'name' => $row['name'],
//             'email' => $row['email'],
//             'password' => Hash::make($row['password']),
//             'show_password' => $row['password'],
//             'mobile' => $row['mobile'],
//             'centercode' => $row['centercode'],
//             'batch_code' => $row['batch_code'],
//             'catyear' => $row['catyear'],
//             'admissiondate' => $row['admissiondate'],
//             'dateofbirth' => $row['dateofbirth'],
//             'address' => $row['address'],
//             'college' => $row['college'],
//         ]);
//     }
// }

protected $errors;

public function collection(Collection $rows)
{
    //dd($rows);
    $this->errors = collect();
    foreach ($rows as $row) {
        // Check if the row with the same email exists in the database
        if (!Studentlog::where('email', $row['email'])->exists()) {
            // Row doesn't exist, so insert it into the database
            $user = DB::table('studentlogs')->insert([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => Hash::make($row['password']),
                'show_password' => $row['password'],
                'mobile' => $row['mobile'],
                'centercode' => $row['centercode'],
               // 'batch_code' => $row['batch_code'],
                'batch_code'   => trim($row['batch_code']),
                'catyear' => $row['catyear'],
                'admissiondate' => $row['admissiondate'],
                'dateofbirth' => $row['dateofbirth'],
                'address' => $row['address'],
                'college' => $row['college'],
            ]);
        }else{
            $this->errors->push("Email already exists !!");
            continue;
        }
    }
}



    public function chunkSize(): int
    {
        return 100;
    }

    public function rules(): array
    {
        return[
       //     'email' => ['email', 'unique:studentlogs'],
        ];
    }

    public function getErrors()
    {
        return $this->errors;
    }
    
}
