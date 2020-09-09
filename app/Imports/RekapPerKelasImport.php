<?php

namespace App\Imports;

use App\Rekap;
use Maatwebsite\Excel\Concerns\ToModel;

class RekapPerKelasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Rekap([
            'tingkat_id' => $row[1],
            'nilai' => $row[2],
            'tahun_pelajaran' => $row[3],
            'semester' => $row[4],
            'user_id' => $row[5],
        ]);
    }
}
