<?php

namespace App\Imports;

use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\GajiKomponen;
use App\Models\Komponen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GajiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $karyawan = Karyawan::where('no_induk', $row['no_induk'])->firstOrFail();

        $gaji = Gaji::updateOrCreate(
            [
                'Bulan' => $row['bulan'],
                'Tahun' => $row['tahun'],
                'karyawans_id' => $karyawan->id,
            ],
            [
                'Gaji_pokok' => $row['gaji_pokok'] ?? $karyawan->gaji_pokok,
            ]
        );

        $komponens = Komponen::all();

        foreach ($komponens as $komponen) {
            $name = strtolower($komponen->Nama);
            if (isset($row[strtolower($komponen->Nama)])) {
                if ($komponen->Jenis == 'persen') {
                    $subTotal = ($row[strtolower($komponen->Nama)] * ($komponen->Nilai * $karyawan->gaji_pokok)/100);
                }

                GajiKomponen::updateOrCreate(
                    [
                        'gajis_id' => $gaji->id,
                        'komponens_id' => $komponen->id,
                    ],
                    [
                        'Qty' => $row[strtolower($komponen->Nama)],
                        'Sub_total' => $subTotal,
                    ]
                );
            }
        }
        return $gaji;
    }
}
