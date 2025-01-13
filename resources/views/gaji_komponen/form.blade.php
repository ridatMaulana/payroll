{{-- filepath: /c:/Users/ASUS/Documents/KP/payroll/resources/views/gaji_komponen/form.blade.php --}}
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
        <div class="col-sm-6"><h1 class="mb-0">{{ isset($gajiKomponen) ? 'Edit' : 'Tambah' }} Komponen Gaji</h1></div>
    </div>
    <div class="container form-container">
        <form action="{{ isset($gajiKomponen) ? route('gaji_komponen.update', $gajiKomponen->id) : route('gaji_komponen.store') }}" method="POST">
            @csrf
            @if(isset($gajiKomponen))
                @method('PUT')
            @endif

            <input type="hidden" name="gajis_id" value="{{ $gaji_id ?? $gajiKomponen->gajis_id }}">

            <div class="komponen-item">
                <div class="mb-3">
                    <label for="komponens_id" class="form-label">Komponen</label>
                    <select name="komponens_id" class="form-select">
                        @foreach($komponens as $komponen)
                            <option value="{{ $komponen->id }}">{{ $komponen->Nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="Qty" class="form-label">Quantity</label>
                    <input type="number" name="Qty" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-custom mb-3">Submit</button>
        </form>
    </div>
</div>
@endsection
