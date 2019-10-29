<?php

namespace App\Exports\Template;

use App\Models\Setting\RouteList;

use App\Exports\MenuExport;
use App\Exports\MenuTypeExport;
use App\Exports\RouteTypeExport;
use App\Exports\RouteControllerTypeExport;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProvinceExportTemplate implements FromCollection, WithHeadings, WithMultipleSheets, WithTitle 
{    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            [
                'name'                          => null,                
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'name',            
        ];
    }

    public function title(): string
    {
        return 'Import File';
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        
        $sheets[] = new ProvinceExportTemplate;                

        return $sheets;
    }
}
