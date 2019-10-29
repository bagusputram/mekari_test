<?php

namespace App\Imports;

use App\Imports\FirstSheetRouteListImport;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class RouteListImport implements WithMultipleSheets 
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function sheets(): array
    {
        return [
            new FirstSheetRouteListImport()
        ];
    }
    
}
