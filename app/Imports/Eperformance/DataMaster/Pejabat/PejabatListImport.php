<?php

namespace App\Imports\Eperformance\DataMaster\Pejabat;

use App\Imports\Eperformance\DataMaster\Pejabat\FirstSheetPejabatImport;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PejabatListImport implements WithMultipleSheets
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function sheets(): array
    {
        return [
            new FirstSheetPejabatImport()
        ];
    }

}
