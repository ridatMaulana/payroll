{{-- filepath: /c:/Users/ASUS/Documents/KP/payroll/resources/views/karyawan_komponen/form.blade.php --}}
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
        <div class="col-sm-6"><h1 class="mb-0">{{ isset($karyawanKomponen) ? 'Edit' : 'Tambah' }} Komponen Karyawan</h1></div>
    </div>
    <div class="container form-container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ isset($karyawanKomponen) ? route('karyawan_komponen.update', $karyawanKomponen->id) : route('karyawan_komponen.store') }}" method="POST">
            @csrf
            @if(isset($karyawanKomponen))
                @method('PUT')
            @endif

            <input type="hidden" name="karyawans_id" value="{{ $karyawan_id ?? $karyawanKomponen->karyawans_id }}">

            <div class="komponen-item">
                <div class="mb-3">
                    <label for="komponens_id" class="form-label">Komponen</label>
                    <select name="komponens_id" class="form-select">
                        @foreach($komponens as $komponen)
                            <option value="{{ $komponen->id }}" {{ old('komponens_id', $karyawanKomponen->komponen->id ?? '') == $komponen->id ? 'selected' : '' }}>{{ $komponen->Nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="Qty" class="form-label">Quantity</label>
                    <input type="number" name="Qty" class="form-control" value="{{ old('Qty', $karyawanKomponen->Qty ?? '') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-custom mb-3">Submit</button>
        </form>
    </div>
</div>
@endsection
