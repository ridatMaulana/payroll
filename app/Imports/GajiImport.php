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

        $gaji = Gaji::create([
            'Bulan' => $row['bulan'],
            'Tahun' => $row['tahun'],
            'Gaji_pokok' => $row['gaji_pokok'] ?? $karyawan->gaji_pokok,
            'karyawans_id' => $karyawan->id,
        ]);

        $komponens = Komponen::all();

        foreach ($komponens as $komponen) {
            $name = strtolower($komponen->Nama);
            if (isset($row[strtolower($komponen->Nama)])) {
                if ($komponen->Jenis == 'persen') {
                    $subTotal = $komponen->tipe == 'tunjangan'
                        ? $gaji->Gaji_pokok + ($row[strtolower($komponen->Nama)] * ($komponen->Nilai * $gaji->Gaji_pokok)/100)
                        : $gaji->Gaji_pokok - ($row[strtolower($komponen->Nama)] * ($komponen->Nilai * $gaji->Gaji_pokok)/100);
                } else {
                    $subTotal = $komponen->tipe == 'tunjangan'
                        ? $gaji->Gaji_pokok + ($row[strtolower($komponen->Nama)] * $komponen->Nilai)
                        : $gaji->Gaji_pokok - ($row[strtolower($komponen->Nama)] * $komponen->Nilai);
                }

                GajiKomponen::create([
                    'Qty' => $row[strtolower($komponen->Nama)],
                    'Sub_total' => $subTotal,
                    'gajis_id' => $gaji->id,
                    'komponens_id' => $komponen->id,
                ]);
            }
        }

        return $gaji;
    }
}
