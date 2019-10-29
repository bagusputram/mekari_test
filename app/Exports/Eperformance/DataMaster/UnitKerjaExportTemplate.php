<?php
namespace App\Exports\Eperformance\DataMaster;

use App\Exports\Eperformance\DataMaster\UnitKerjaExport;
use App\Exports\Eperformance\DataMaster\EselonisasiExport;

use Maatwebsite\Excel\Concerns\Exportable;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class UnitKerjaExportTemplate implements FromCollection, WithHeadings, WithMultipleSheets, WithTitle
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            [
                'unit_nama' => null,
                'unit_initial' => null,
                'unit_deskripsi' => null,
                'unit_tahun_penetapan' => null,
                'unit_tahun_selesai' => null,
                'unit_parent_id' => null,
                'eselonisasi_id' => null,
                'unit_is_active' => null,
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'unit_nama',
            'unit_initial',
            'unit_deskripsi',
            'unit_tahun_penetapan',
            'unit_tahun_selesai',
            'unit_parent_id',
            'eselonisasi_id',
            'unit_is_active',
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

        $sheets[] = new UnitKerjaExportTemplate;
        $sheets[] = new UnitKerjaExport;
        $sheets[] = new EselonisasiExport;

        return $sheets;
    }
}