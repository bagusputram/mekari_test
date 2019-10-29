<?php

namespace App\Exports\Eperformance\DataMaster;

use App\Exports\Eperformance\DataMaster\UnitKerjaExport;
use App\Exports\MasterData\GenderExport;
use App\Exports\MasterData\UserRoleExport;

use Maatwebsite\Excel\Concerns\Exportable;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class PejabatExportTemplate implements FromCollection, WithHeadings, WithMultipleSheets, WithTitle
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            [
                'pejabat_nama' => null,
                'pejabat_nip' => null,
                'pejabat_telepon' => null,
                'pejabat_alamat' => null,
                'pejabat_tahun_penetapan' => null,
                'pejabat_tahun_selesai' => null,
                'gender_name' => null,
                'unit_name' => null,
                'pejabat_is_active' => null,
                'email' => null,
                'username' => null,
                'user_role_name' => null,
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'pejabat_nama',
            'pejabat_nip',
            'pejabat_telepon',
            'pejabat_alamat',
            'pejabat_tahun_penetapan',
            'pejabat_tahun_selesai',
            'gender_name',
            'unit_name',
            'pejabat_is_active',
            'email',
            'username',
            'user_role_name',
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

        $sheets[] = new PejabatExportTemplate;
        $sheets[] = new UnitKerjaExport;
        $sheets[] = new GenderExport;
        $sheets[] = new UserRoleExport;

        return $sheets;
    }
}

?>
