@extends('layouts.dashboard')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dark-datatable.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="container-fluid py-4">
    <form action="{{ route('notification.send') }}" method="POST">
        @csrf
        <div class="row mb-4">
            <div class="col-sm-6"><h1 class="mb-0">Kirim Notifikasi</h1></div>
            <div class="col-sm-6 text-end">
                <button type="submit" class="btn btn-primary">Kirim Notifikasi</button>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-bordered" id="salaryTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Periode</th>
                            <th>Gaji Pokok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($gajis as $gaji)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $gaji->karyawan->nama }}</td>
                            <td>{{ \Carbon\Carbon::createFromDate($gaji->Tahun, $gaji->Bulan, 1)->locale('id')->isoFormat('MMMM YYYY') }}</td>
                            <td>{{ $gaji->Gaji_pokok }}</td>
                            <td>
                                <input type="checkbox" name="gaji_ids[]" value="{{ $gaji->id }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#salaryTable').DataTable();
    });
    </script>
@endpush
