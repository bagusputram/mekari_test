<?php

namespace App\Exports;

use App\Models\Setting\RouteType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class RouteTypeExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function map($route_type): array
    {        
        return [
            $route_type->id,
            $route_type->name,
        ];
    }

    public function collection()
    {
        return RouteType::all();;
    }

    public function headings(): array
    {
        return [
            'Route Type Name',            
        ];
    }

    public function title(): string
    {
        return 'Route Type Master Data';
    }
}
