<?php

namespace App\Exports;

use App\Models\Setting\MenuType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class MenuTypeExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function map($menu_type): array
    {        
        return [
            $menu_type->id,
            $menu_type->name,
        ];
    }

    public function collection()
    {
        return MenuType::all();;
    }

    public function headings(): array
    {
        return [
            'Menu Type Name',            
        ];
    }

    public function title(): string
    {
        return 'Menu Type Master Data';
    }
}
