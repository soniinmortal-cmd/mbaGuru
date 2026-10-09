<?php

namespace App\Exports;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Studentlog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUser implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Studentlog::select('name','email')->get();
    }
    
      public function headings(): array
    {
        return ['NAME','EMAIL'];
    }
}


