@extends('layouts.dashboard')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <style>
        .form-container {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .btn-custom {
            color: white;
        }
        .form-select {
            color: black;
        }
    </style>
@endpush
@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-sm-6"><h1 class="mb-0">Karyawan</h1></div>
    </div>
    <div class="container form-container">
        {{--  --}}
        <form action="{{ isset($karyawan) ? route('karyawan.update', $karyawan->id) : route('karyawan.store') }}" method="POST">
            @csrf
            @if(isset($karyawan))
                @method('PUT')
            @endif
            <div class="mb-3">
                <label for="no_induk" class="form-label">No Induk</label>
                <input type="text" class="form-control" id="no_induk" name="no_induk" value="{{ old('no_induk', $karyawan->no_induk ?? '') }}">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $karyawan->nama ?? '') }}">
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir ?? '') }}">
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                    <option value="L" {{ old('jenis_kelamin', $karyawan->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $karyawan->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat">{{ old('alamat', $karyawan->alamat ?? '') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan', $karyawan->jabatan ?? '') }}">
            </div>
            <div class="mb-3">
                <label for="whatsapp" class="form-label">WhatsApp</label>
                <input type="text" class="form-control" id="whatsapp" name="no_wa" value="{{ old('no_wa', $karyawan->no_wa ?? '') }}" pattern="\d*">
            </div>
            <div class="mb-3">
                <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok', $karyawan->gaji_pokok ?? '') }}">
            </div>
            @if(!isset($karyawan))
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                </div>
            @endif
            {{-- <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role', $karyawan->user->roles_id ?? '') == $role->id ? 'selected' : '' }}>{{ $role->nama }}</option>
                    @endforeach
                </select>
            </div> --}}
            <button type="submit" class="btn btn-custom">Submit</button>
        </form>
    </div>
</div>
@endsection
