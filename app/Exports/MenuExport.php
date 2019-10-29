<?php

namespace App\Exports;

use App\Models\Setting\Menu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class MenuExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function map($menu): array
    {        
        return [
            $menu->id,
            $menu->menu_name,
        ];
    }

    public function collection()
    {
        return Menu::all();;
    }

    public function headings(): array
    {
        return [
            'Menu Name',            
        ];
    }

    public function title(): string
    {
        return 'Menu Master Data';
    }
}
