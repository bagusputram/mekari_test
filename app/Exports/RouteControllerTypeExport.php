<?php

namespace App\Exports;

use App\Models\Setting\RouteControllerType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class RouteControllerTypeExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function map($route_controller_type): array
    {        
        return [
            $route_controller_type->id,            
            $route_controller_type->name,            
        ];
    }

    public function collection()
    {
        return RouteControllerType::all();;
    }

    public function headings(): array
    {
        return [
            'Route Controller Type Name',            
        ];
    }

    public function title(): string
    {
        return 'Controller Type Name';
    }
}
