<?php

namespace App\Exports\Eperformance\DataMaster;

use App\Models\Eperformance\DataMaster\Eselonisasi;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class EselonisasiExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function map($eselonisasi): array
    {
        return [
            $eselonisasi->id,
            $eselonisasi->eselonisasi_nama,
        ];
    }

    public function collection()
    {
        return Eselonisasi::all();;
    }

    public function headings(): array
    {
        return [
            'Eselon ID',
            'Eselon Name',
        ];
    }

    public function title(): string
    {
        return 'Eselon Data Master';
    }
}
