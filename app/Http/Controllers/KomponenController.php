<?php

namespace App\Http\Controllers;

use App\Models\Komponen;
use Illuminate\Http\Request;

class KomponenController extends Controller
{
    public function index()
    {
        $data = Komponen::all();
        return view('komponen/index')->with('data', $data);
    }

    public function create()
    {
        return view('komponen/form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nama' => 'required|string|max:100',
            'tipe' => 'required|string|max:10',
            'Jenis' => 'required|string|max:10',
            'Nilai' => 'required|numeric',
        ]);

        Komponen::create($request->all());

        return redirect()->route('komponen.index')->with('success', 'Komponen created successfully.');
    }

    public function edit($id)
    {
        $komponen = Komponen::findOrFail($id);
        return view('komponen/form', compact('komponen'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Nama' => 'required|string|max:100',
            'tipe' => 'required|string|max:10',
            'Jenis' => 'required|string|max:10',
            'Nilai' => 'required|numeric',
        ]);

        $komponen = Komponen::findOrFail($id);
        $komponen->update($request->all());

        return redirect()->route('komponen.index')->with('success', 'Komponen updated successfully.');
    }

    public function destroy($id)
    {
        $komponen = Komponen::findOrFail($id);
        $komponen->delete();

        return redirect()->route('komponen.index')->with('success', 'Komponen deleted successfully.');
    }
}
