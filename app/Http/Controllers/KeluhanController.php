<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use App\Models\Gaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeluhanController extends Controller
{
    public function create($gaji_id)
    {
        $gaji = Gaji::findOrFail($gaji_id);
        return view('keluhan.create', compact('gaji'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
            'gajis_id' => 'required|uuid',
        ]);

        Keluhan::create([
            'keterangan' => $request->keterangan,
            'gajis_id' => $request->gajis_id,
        ]);

        return redirect()->back()->with('success', 'Keluhan berhasil diajukan.');
    }

    public function index()
    {
        $keluhans = Keluhan::all();
        return view('keluhan.index', compact('keluhans'));
    }

    public function approve($id)
    {
        $keluhan = Keluhan::findOrFail($id);
        $keluhan->update(['status' => 'approved']);
        return redirect()->route('keluhan.index')->with('success', 'Keluhan berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $keluhan = Keluhan::findOrFail($id);
        $keluhan->update([
            'status' => 'rejected',
            'alasan_ditolak' => $request->alasan_ditolak,
        ]);
        return redirect()->route('keluhan.index')->with('success', 'Keluhan berhasil ditolak.');
    }
}
