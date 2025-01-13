<?php

namespace App\Http\Controllers;

use App\Models\GajiKomponen;
use App\Models\Komponen;
use App\Models\Gaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GajiKomponenController extends Controller
{
    public function show($gaji_id)
    {
        $data = GajiKomponen::where('gajis_id', $gaji_id)->get();
        $gaji = Gaji::findOrFail($gaji_id);

        $bulanIndo = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $periode = $gaji->karyawan->nama . ' ' . $bulanIndo[(int)$gaji->Bulan] . ' ' . $gaji->Tahun;

        return view('gaji_komponen/index', compact('data', 'gaji_id', 'periode'));
    }

    public function create($gaji_id)
    {
        $komponens = Komponen::all();
        return view('gaji_komponen/form', compact('gaji_id', 'komponens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gajis_id' => 'required',
            'komponens_id' => 'required',
            'Qty' => 'required|integer',
        ]);

        try {
            $gaji = Gaji::findOrFail($request->gajis_id);
            $komponenModel = Komponen::findOrFail($request->komponens_id);

            if ($komponenModel->Jenis == 'persen') {
                $sub_total =  ($request->Qty * ($komponenModel->Nilai * $gaji->Gaji_pokok)/100);
            } else {
                $sub_total = ($request->Qty * $komponenModel->Nilai);
            }

            $data = [
                'gajis_id' => $request->gajis_id,
                'komponens_id' => $request->komponens_id,
                'Qty' => $request->Qty,
                'Sub_total' => $sub_total,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            GajiKomponen::create($data);

            return redirect()->route('gaji_komponen.show', $request->gajis_id)->with('success', 'Komponen added successfully.');
        } catch (\Exception $e) {
            Log::error('Error adding komponen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add komponen. Please try again.');
        }
    }

    public function edit($id)
    {
        $gajiKomponen = GajiKomponen::findOrFail($id);
        $komponens = Komponen::all();
        return view('gaji_komponen/form', compact('gajiKomponen', 'komponens'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'komponens_id' => 'required',
            'Qty' => 'required|integer',
        ]);

        try {
            $gajiKomponen = GajiKomponen::findOrFail($id);
            if ($gajiKomponen->komponen->Jenis == 'persen') {
                $subTotal = ($request->Qty * ($gajiKomponen->komponen->Nilai * $gajiKomponen->gaji->Gaji_pokok)/100);
            } else {
                $subTotal = ($request->Qty * $gajiKomponen->komponen->Nilai);
            }
            $data = [
                'gajis_id' => $request->gajis_id,
                'komponens_id' => $request->komponens_id,
                'Qty' => $request->Qty,
                'Sub_total' => $subTotal,
            ];
            $gajiKomponen->update($data);
            return redirect()->route('gaji_komponen.show', $gajiKomponen->gajis_id)->with('success', 'Komponen updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating komponen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update komponen. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $gajiKomponen = GajiKomponen::findOrFail($id);
            $gajiKomponen->delete();

            return redirect()->route('gaji_komponen.show', $gajiKomponen->gajis_id)->with('success', 'Komponen deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting komponen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete komponen. Please try again.');
        }
    }
}
