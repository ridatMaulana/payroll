@extends('layouts.dashboard')
@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <style>
        .year, .year .focused {
            color: white;
        }
        .year:hover {
            color: black;
        }
    </style>
@endpush
@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-sm-6"><h1 class="mb-0">{{ isset($gaji) ? 'Edit' : 'Tambah' }} Gaji</h1></div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($gaji) ? route('gaji.update', $gaji->id) : route('gaji.store') }}" method="POST">
                        @csrf
                        @if(isset($gaji))
                            @method('PUT')
                        @endif
                        <div class="form-group mb-3">
                            <label for="Bulan" class="form-label">Bulan</label>
                            <select name="Bulan" id="Bulan" class="form-control" required>
                                <option value="1" {{ isset($gaji) && $gaji->Bulan == 1 ? 'selected' : '' }}>Januari</option>
                                <option value="2" {{ isset($gaji) && $gaji->Bulan == 2 ? 'selected' : '' }}>Februari</option>
                                <option value="3" {{ isset($gaji) && $gaji->Bulan == 3 ? 'selected' : '' }}>Maret</option>
                                <option value="4" {{ isset($gaji) && $gaji->Bulan == 4 ? 'selected' : '' }}>April</option>
                                <option value="5" {{ isset($gaji) && $gaji->Bulan == 5 ? 'selected' : '' }}>Mei</option>
                                <option value="6" {{ isset($gaji) && $gaji->Bulan == 6 ? 'selected' : '' }}>Juni</option>
                                <option value="7" {{ isset($gaji) && $gaji->Bulan == 7 ? 'selected' : '' }}>Juli</option>
                                <option value="8" {{ isset($gaji) && $gaji->Bulan == 8 ? 'selected' : '' }}>Agustus</option>
                                <option value="9" {{ isset($gaji) && $gaji->Bulan == 9 ? 'selected' : '' }}>September</option>
                                <option value="10" {{ isset($gaji) && $gaji->Bulan == 10 ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ isset($gaji) && $gaji->Bulan == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ isset($gaji) && $gaji->Bulan == 12 ? 'selected' : '' }}>Desember</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="Tahun" class="form-label">Tahun</label>
                            <input type="text" name="Tahun" id="Tahun" class="form-control yearpicker" value="{{ isset($gaji) ? $gaji->Tahun : '' }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="Gaji_pokok" class="form-label">Gaji Pokok</label>
                            <input type="number" name="Gaji_pokok" id="Gaji_pokok" class="form-control" value="{{ isset($gaji) ? $gaji->Gaji_pokok : '' }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="karyawans_id" class="form-label">Karyawan</label>
                            <select name="karyawans_id" id="karyawans_id" class="form-control" required>
                                @foreach($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}" {{ isset($gaji) && $gaji->karyawans_id == $karyawan->id ? 'selected' : '' }}>{{ $karyawan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.yearpicker').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true
            });
        });
        let komponenIndex = {{ isset($gaji) ? $gaji->gajiKomponen->count() : 1 }};
        document.getElementById('add-komponen').addEventListener('click', function() {
            const newKomponen = document.querySelector('.komponen').cloneNode(true);
            newKomponen.querySelectorAll('select, input').forEach(function(input) {
                input.name = input.name.replace(/\d+/, komponenIndex);
                input.value = '';
            });
            document.getElementById('additional-komponens').appendChild(newKomponen);
            komponenIndex++;
        });
    </script>
@endpush
