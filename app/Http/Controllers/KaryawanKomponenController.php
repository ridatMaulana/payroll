<?php

namespace App\Http\Controllers;

use App\Models\KaryawanKomponen;
use App\Models\Komponen;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KaryawanKomponenController extends Controller
{
    public function show($karyawan_id)
    {
        $data = KaryawanKomponen::where('karyawans_id', $karyawan_id)->get();
        $nama_karyawan = Karyawan::findOrFail($karyawan_id)->nama;
        return view('karyawan_komponen/index', compact('data', 'karyawan_id', 'nama_karyawan'));
    }

    public function create($karyawan_id)
    {
        $komponens = Komponen::all();
        return view('karyawan_komponen/form', compact('karyawan_id', 'komponens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawans_id' => 'required',
            'komponens_id' => 'required',
            'Qty' => 'required|numeric',
        ]);

        try {
            $karyawan = Karyawan::findOrFail($request->karyawans_id);
            $komponen = $request->komponens;
            $komponenModel = Komponen::findOrFail($request->komponens_id);

            if ($komponenModel->Jenis == 'persen') {
                $sub_total = ($request->Qty * ($komponenModel->Nilai * $karyawan->gaji_pokok)/100);
            } else {
                $sub_total = ($request->Qty*($komponenModel->Nilai));
            }

            $data = [
                'karyawans_id' => $request->karyawans_id,
                'komponens_id' => $request->komponens_id,
                'Qty' => $request->Qty,
                'Sub_total' => $sub_total,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            KaryawanKomponen::create($data);

            return redirect()->route('karyawan_komponen.index')->with('success', 'Komponen Karyawan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error adding komponen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengirim data. Silakan coba lagi.');
        }
    }

    public function edit($id)
    {
        $karyawanKomponen = KaryawanKomponen::findOrFail($id);
        $komponens = Komponen::all();
        return view('karyawan_komponen/form', compact('karyawanKomponen', 'komponens'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'karyawans_id' => 'required',
            'komponens_id' => 'required',
            'Qty' => 'required|numeric',
        ]);

        try {
            $karyawanKomponen = KaryawanKomponen::findOrFail($id);

            if ($karyawanKomponen->Komponen->Jenis == 'persen') {
                $sub_total = ($request->Qty * ($karyawanKomponen->Komponen->Nilai * $karyawanKomponen->karyawan->gaji_pokok)/100);
            } else {
                $sub_total = ($request->Qty*($karyawanKomponen->Komponen->Nilai));
            }
            $data = [
                'karyawans_id' => $request->karyawans_id,
                'komponens_id' => $request->komponens_id,
                'Qty' => $request->Qty,
                'Sub_total' => $sub_total,
                'updated_at' => now(),
            ];
            $karyawanKomponen->update($data);
            // dd($sub_total);

            return redirect()->route('karyawan_komponen.show', $karyawanKomponen->karyawans_id)->with('success', 'Komponen Karyawan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating komponen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengirim data. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        try {
            $karyawanKomponen = KaryawanKomponen::findOrFail($id);
            $karyawanKomponen->delete();

            return redirect()->route('karyawan_komponen.show', $karyawanKomponen->karyawans_id)->with('success', 'Komponen deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting komponen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete komponen. Please try again.');
        }
    }
}
