@extends('layouts.dashboard')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dark-datatable.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-sm-6"><h1 class="mb-0">Notifikasi WhatsApp</h1></div>
        <div class="col-sm-6 text-end">
            <a href="{{ route('notification.sendForm') }}" class="btn btn-primary">Tambah Notifikasi</a>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-dark table-striped table-bordered" id="notificationTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Tanggal Pengiriman</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($notifications as $notification)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $notification->gaji->karyawan->nama }}</td>
                        <td>{{ \Carbon\Carbon::createFromDate($notification->gaji->Tahun, $notification->gaji->Bulan, 1)->locale('id')->isoFormat('MMMM YYYY') }}</td>
                        <td>{{ $notification->status ? 'Terkirim' : 'Tidak Terkirim' }}</td>
                        <td>{{ $notification->keterangan }}</td>
                        <td>{{ $notification->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
    $(document).ready(function() {
        $('#notificationTable').DataTable();
    });
    </script>
@endpush
