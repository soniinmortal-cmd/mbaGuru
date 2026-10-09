<?php

namespace App\Exports;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Studentlog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportAdmin implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Studentlog::select('name','email','mobile','password','batch_code','admissiondate','dateofbirth','address')->get();
    }
    
      public function headings(): array
    {
        return ['NAME','EMAIL','MOBILE','PASSWORD','BATCHCODE','ADMISSIONDATE','DATEOFBIRTH ','ADDRESS'];
    }
}


// namespace App\Exports;

// use App\Models\Admin;
// use Maatwebsite\Excel\Concerns\FromCollection;

// class ExportAdmin implements FromCollection
// {
//     /**
//     * @param array $row
//     *
//     * @return \Illuminate\Database\Eloquent\Model|null
//     */
//     // public function model(array $row)
//      public function collection()
//     {
//         return User::all();
//     }
    //{
        // return new Admin([
        //     'name' => $row[0],
        //     'email' => $row[1],
        //      'mobile' => $row[2],
        //     'password' => bcrypt($row[3]),
        //      'centercode' => $row[4],
        //       'batchcode' => $row[5],
        //       'catyear' => $row[6],
        //         'admissiondate' => $row[7],
        //          'dateofbirth' => $row[8],
        //          'address' => $row[9],
        //          'college' => $row[10],
        // ]);
//     }
// }


// <?php
// namespace App\Exports;
// use App\Models\User;
// use Maatwebsite\Excel\Concerns\FromCollection;
// class UsersExport implements FromCollection
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         return User::all();
//     }
//}