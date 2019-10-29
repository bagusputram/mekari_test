<?php

namespace App\Imports\Eperformance\DataMaster;

use App\Imports\FirstSheetRouteListImport;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class UnitKerjaListImport implements WithMultipleSheets
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function sheets(): array
    {
        return [
            new FirstSheetUnitKerjaImport()
        ];
    }

}
