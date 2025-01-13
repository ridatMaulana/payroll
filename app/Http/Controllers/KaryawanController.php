<?php

namespace App\Http\Controllers;

use App\Models\KaryawanKomponen;
use App\Models\Karyawan;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $data = Karyawan::all();
        return view('karyawan/index')->with('data', $data);
    }

    public function create()
    {
        // $roles = Role::where('id', '!=', 1)->get();, compact('roles')
        return view('karyawan/form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_induk' => 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'jabatan' => 'required',
            'no_wa' => 'required',
            'gaji_pokok' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            // 'role' => 'required',
        ]);

        $user = User::create([
            'username' => strtolower(str_replace(' ', '', $request->nama)),
            'email' => $request->email,
            'password' => Hash::make('cianjurjago'), // Set a default password
            'roles_id' => 3, //$request->role
        ]);

        Karyawan::create([
            'no_induk' => $request->no_induk,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'jabatan' => $request->jabatan,
            'no_wa' => $request->no_wa,
            'gaji_pokok' => $request->gaji_pokok,
            'users_id' => $user->id,
        ]);

        return redirect()->route('karyawan')->with('success', 'Karyawan created successfully.');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $roles = Role::where('id', '!=', 1)->get();
        return view('karyawan/form', compact('karyawan', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_induk' => 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'jabatan' => 'required',
            'no_wa' => 'required',
            'gaji_pokok' => 'required|numeric',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        if($request->input('gaji_pokok') != null) {
            if($karyawan->gaji_pokok != $request->input('gaji_pokok')) {
                $karyawanKomponen = KaryawanKomponen::where('karyawans_id', $id)->get();
                foreach($karyawanKomponen as $komponen) {
                    if ($komponen->komponen->Jenis == 'persen') {
                        $subTotal = ($komponen->Qty * ($komponen->komponen->Nilai * $request->input('gaji_pokok'))/100);
                    }
                    $data = [
                        'karyawans_id' => $karyawan->id,
                        'komponens_id' => $komponen->komponens_id,
                        'Qty' => $komponen->Qty,
                        'Sub_total' => $subTotal,
                    ];
                    $komponen->update($data);
                }
            }
        }
        $karyawan->update($request->all());

        return redirect()->route('karyawan')->with('success', 'Karyawan updated successfully.');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $user = User::findOrFail($karyawan->users_id);

        $karyawan->delete();
        $user->delete();

        return redirect()->route('karyawan')->with('success', 'Karyawan deleted successfully.');
    }
}
