<?php

namespace App\Exports\MasterData;

use App\Models\Setting\Gender;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class GenderExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function map($gender): array
    {        
        return [
            $gender->gender_name,            
        ];
    }

    public function collection()
    {
        return Gender::all();;
    }

    public function headings(): array
    {
        return [
            'Gender Name',            
        ];
    }

    public function title(): string
    {
        return 'Gender Master Data';
    }
}
