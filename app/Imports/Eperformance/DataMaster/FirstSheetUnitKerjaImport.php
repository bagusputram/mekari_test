<?php

namespace App\Imports\Eperformance\DataMaster;

use App\Models\Eperformance\DataMaster\Eselonisasi;
use App\Models\Eperformance\DataMaster\UnitKerja;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Auth;

class FirstSheetUnitKerjaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $row['eselonisasi_id'] = Eselonisasi::where('eselonisasi_nama', 'like', $row['eselonisasi_id'])->first()->id;
        $row['unit_parent_id'] = UnitKerja::where('unit_nama', 'like', '%'.$row['unit_parent_id'].'%')->first()->id;

        $unit_code = generateUnitCode($row['unit_parent_id']);

        // dd($row['unit_nama']);

        return new UnitKerja([
            'unit_initial' => $row['unit_initial'],
            'unit_nama' => $row['unit_nama'],
            'unit_deskripsi' => $row['unit_deskripsi'],
            'unit_tahun_penetapan' => $row['unit_tahun_penetapan'],
            'unit_tahun_selesai' => $row['unit_tahun_selesai'],
            'unit_is_active' => $row['unit_is_active'],
            'unit_parent_id' => $row['unit_parent_id'],
            'eselonisasi_id' => $row['eselonisasi_id'],
            'unit_kode' => $unit_code,
            'unit_created_by' => Auth::user()->id,

        ]);
    }


}
