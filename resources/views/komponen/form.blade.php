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
        <div class="col-sm-6"><h1 class="mb-0">Komponen</h1></div>
    </div>
    <div class="container form-container">
        <form action="{{ isset($komponen) ? route('komponen.update', $komponen->id) : route('komponen.store') }}" method="POST">
            @csrf
            @if(isset($komponen))
                @method('PUT')
            @endif
            <div class="mb-3">
                <label for="Nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="Nama" name="Nama" value="{{ old('Nama', $komponen->Nama ?? '') }}">
            </div>
            <div class="mb-3">
                <label for="tipe" class="form-label">Tipe</label>
                <select class="form-select" id="tipe" name="tipe">
                    <option value="denda" {{ old('tipe', $komponen->tipe ?? '') == 'denda' ? 'selected' : '' }}>Denda</option>
                    <option value="tunjangan" {{ old('tipe', $komponen->tipe ?? '') == 'tunjangan' ? 'selected' : '' }}>Tunjangan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="Jenis" class="form-label">Jenis</label>
                <select class="form-select" id="Jenis" name="Jenis">
                    <option value="persen" {{ old('Jenis', $komponen->Jenis ?? '') == 'persen' ? 'selected' : '' }}>Persen</option>
                    <option value="nominal" {{ old('Jenis', $komponen->Jenis ?? '') == 'nominal' ? 'selected' : '' }}>Nominal</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="Nilai" class="form-label">Nilai</label>
                <input type="number" class="form-control" id="Nilai" name="Nilai" value="{{ old('Nilai', $komponen->Nilai ?? '') }}">
            </div>
            <button type="submit" class="btn btn-custom">Submit</button>
        </form>
    </div>
</div>
@endsection
