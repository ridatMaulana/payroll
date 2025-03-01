<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\GajiKomponen;
use App\Models\Komponen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GajiImport;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

class GajiController extends Controller
{
    public function index()
    {
        $gajis = Gaji::all();
        return view('gaji.index', compact('gajis'));
    }

    public function create()
    {
        $karyawans = Karyawan::all();
        $komponens = Komponen::all();
        return view('gaji.form', compact('karyawans', 'komponens'));
    }

    public function store(Request $request)
    {
        $karyawan = Karyawan::findOrFail($request->input('karyawans_id'));
        $gajiPokok = $karyawan->gaji_pokok;
        if(null !== $request->input('Gaji_pokok')) {
            $gajiPokok = $request->input('Gaji_pokok');
        }
        $gaji = Gaji::create([
            'Bulan' => $request->input('Bulan'),
            'Tahun' => $request->input('Tahun'),
            'Gaji_pokok' => $gajiPokok,
            'karyawans_id' => $request->input('karyawans_id')
        ]);
        $this->updateGajiKomponen($gaji, $request->input('komponens', []));
        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $gaji = Gaji::findOrFail($id);
        $karyawans = Karyawan::all();
        $komponens = Komponen::all();
        return view('gaji.form', compact('gaji', 'karyawans', 'komponens'));
    }

    public function update(Request $request, $id)
    {
        $gaji = Gaji::findOrFail($id);
        $karyawan = Karyawan::findOrFail($request->input('karyawans_id'));
        $gajiPokok = $request->input('Gaji_pokok', $karyawan->gaji_pokok);
        if($request->input('Gaji_pokok') != null) {
            if($gaji->Gaji_pokok != $request->input('Gaji_pokok')) {
                $gajiKomponen = GajiKomponen::where('gajis_id', $id)->get();
                foreach($gajiKomponen as $komponen) {
                    if ($komponen->komponen->Jenis == 'persen') {
                        $subTotal = ($komponen->Qty * ($komponen->komponen->Nilai * $request->input('Gaji_pokok'))/100);
                    }
                    $data = [
                        'gajis_id' => $gaji->id,
                        'komponens_id' => $komponen->komponens_id,
                        'Qty' => $komponen->Qty,
                        'Sub_total' => $subTotal,
                    ];
                    $komponen->update($data);
                }
            }
        }
        $gaji->update([
            'Bulan' => $request->input('Bulan'),
            'Tahun' => $request->input('Tahun'),
            'Gaji_pokok' => $gajiPokok,
            'karyawans_id' => $request->input('karyawans_id')
        ]);
        $this->updateGajiKomponen($gaji, $request->input('komponens', []));
        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $gaji = Gaji::findOrFail($id);
        $gaji->delete();
        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $data = Excel::import(new GajiImport, $request->file('file'));
        // dd($data->all());

        return redirect()->route('gaji.index')->with('success', 'Gaji imported successfully.');
    }

    private function updateGajiKomponen(Gaji $gaji, array $additionalKomponens = [])
    {
        $karyawan = $gaji->karyawan;
        foreach ($karyawan->karyawanKomponen as $karyawanKomponen) {
            $komponenModel = $karyawanKomponen->komponen;
            if ($komponenModel->Jenis == 'persen') {
                $subTotal = ($karyawanKomponen->Qty * ($komponenModel->Nilai * $gaji->Gaji_pokok)/100);
            } else {
                $subTotal = ($karyawanKomponen->Qty * $komponenModel->Nilai);
            }

            GajiKomponen::updateOrCreate(
                ['gajis_id' => $gaji->id, 'komponens_id' => $karyawanKomponen->komponens_id],
                ['Qty' => $karyawanKomponen->Qty, 'Sub_total' => $subTotal]
            );
        }

        foreach ($additionalKomponens as $komponen) {
            $komponenModel = Komponen::find($komponen['komponens_id']);
            if ($komponenModel->Jenis == 'persen') {
                $subTotal = ($komponen['Qty'] * ($komponenModel->Nilai * $gaji->Gaji_pokok))/100;
            } else {
                $subTotal = ($komponen['Qty'] * $komponenModel->Nilai);
            }

            GajiKomponen::updateOrCreate(
                ['gajis_id' => $gaji->id, 'komponens_id' => $komponen['komponens_id']],
                ['Qty' => $komponen['Qty'], 'Sub_total' => $subTotal]
            );
        }
    }

    public function print()
    {
        $gajis = Gaji::with('gajiKomponen.komponen', 'karyawan')->get();
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('gaji.print', compact('gajis', 'months'));
        return $pdf->download('gaji_report.pdf');
    }

    public function show($karyawan_id)
    {
        $gajis = Gaji::where('karyawans_id', $karyawan_id)->get();
        return view('gaji.index', compact('gajis'));

    }

    public function slipPrint($gaji_id)
    {
        $gaji = Gaji::with('gajiKomponen.komponen', 'karyawan')->findOrFail($gaji_id);
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        foreach ($gaji->gajiKomponen as $komponen) {
            $komponenModel = $komponen->komponen;
            if ($komponenModel->Jenis == 'persen') {
                $komponen->Sub_total = ($komponen->Qty * ($komponenModel->Nilai * $gaji->Gaji_pokok)/100);
            } else {
                $komponen->Sub_total = ($komponen->Qty * $komponenModel->Nilai);
            }
        }

        $totalTunjangan = $gaji->gajiKomponen->where('komponen.tipe', 'tunjangan')->sum('Sub_total');
        $totalDenda = $gaji->gajiKomponen->where('komponen.tipe', 'denda')->sum('Sub_total');
        $gajiBersih = $gaji->Gaji_pokok + $totalTunjangan - $totalDenda;

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('gaji.slip', compact('gaji', 'months', 'totalTunjangan', 'totalDenda', 'gajiBersih'));
        return $pdf->download('slip_gaji_' . $gaji->karyawan->nama . '(' . $months[$gaji->Bulan] . $gaji->Tahun . ').pdf');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $latestGaji = Gaji::orderBy('Tahun', 'desc')->orderBy('Bulan', 'desc')->first();

        $totalGaji = 0;
        $totalDenda = 0;
        $totalTunjangan = 0;

        if ($latestGaji) {
            $latestBulan = $latestGaji->Bulan;
            $latestTahun = $latestGaji->Tahun;

            if ($user->role->nama == 'Karyawan') {
                $gajis = Gaji::where('karyawans_id', $user->karyawan->id)
                    ->where('Bulan', $latestBulan)
                    ->where('Tahun', $latestTahun)
                    ->get();
            } else {
                $gajis = Gaji::where('Bulan', $latestBulan)
                    ->where('Tahun', $latestTahun)
                    ->get();
            }

            foreach ($gajis as $gaji) {
                $totalGaji += $gaji->Gaji_pokok;
                foreach ($gaji->gajiKomponen as $komponen) {
                    if ($komponen->komponen->tipe == 'tunjangan') {
                        $totalTunjangan += $komponen->Sub_total;
                    } elseif ($komponen->komponen->tipe == 'denda') {
                        $totalDenda += $komponen->Sub_total;
                    }
                }
            }

            $gajiBersih = $totalGaji + $totalTunjangan - $totalDenda;

            return view('dashboard.index', compact('totalGaji', 'totalDenda', 'totalTunjangan', 'gajiBersih'));
        }

        return view('dashboard.index', compact('totalGaji', 'totalDenda', 'totalTunjangan', 'gajiBersih'));
    }
}
