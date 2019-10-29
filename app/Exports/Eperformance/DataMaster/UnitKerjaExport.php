<?php

namespace App\Exports\Eperformance\DataMaster;

use App\Models\Eperformance\DataMaster\UnitKerja;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class UnitKerjaExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function map($unit_kerja): array
    {
        return [
            $unit_kerja->id,
            $unit_kerja->unit_nama,
            $unit_kerja->unit_initial,
        ];
    }

    public function collection()
    {
        return UnitKerja::all();;
    }

    public function headings(): array
    {
        return [
            'Unit ID',
            'Unit Name',
            'Unit Initial',
        ];
    }

    public function title(): string
    {
        return 'Unit Kerja Data Master';
    }
}
