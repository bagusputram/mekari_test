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

class RouteListExportTemplate implements FromCollection, WithHeadings, WithMultipleSheets, WithTitle 
{    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            [
                'name'                          => null,
                'route_type_id'                 => null,
                'route_controller_type_id'      => null,
                'route_controller_name'         => null,
                'route_menu_name'               => null,
                'menu_type_id'                  => null,
                'menu_id'                       => null,
                'route_link'                    => null,
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'name',
            'route_type_id',
            'route_controller_type_id',
            'route_controller_name',
            'route_menu_name',
            'menu_type_id',
            'menu_id',
            'route_link',
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
        
        $sheets[] = new RouteListExportTemplate;        
        $sheets[] = new RouteTypeExport;
        $sheets[] = new RouteControllerTypeExport;
        $sheets[] = new MenuTypeExport;
        $sheets[] = new MenuExport;

        return $sheets;
    }
}
