@extends('layouts.dashboard')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dark-datatable.css') }}" rel="stylesheet">
    <style>
        .modal-content {
            background-color: #343a40; /* Dark background */
            color: #fff; /* White text */
        }
        .btn-close {
            filter: invert(1); /* Make the close button icon white */
        }
    </style>
@endpush
@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-sm-6"><h1 class="mb-0">Komponen Gaji </h1><h2 class="mb-0">({{$periode}})</h2></div>
        <div class="col-sm-6 text-end">
            <a href="{{ route('gaji_komponen.create', ['gaji_id' => $gaji_id]) }}" class="btn btn-primary my-auto">Tambah Komponen</a>
        </div>
    </div>
    <div class="row">
        <table class="table table-dark table-striped table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Komponen</th>
                    <th>Qty</th>
                    <th>Sub Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                $no = 1;
                @endphp
                @foreach ($data as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->komponen->Nama }}</td>

                    <td>{{ $item->Qty }}</td>
                    <td>{{ $item->Sub_total }}</td>
                    <td>
                        <a href="{{ route('gaji_komponen.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('gaji_komponen.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return false;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $item->id }}">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var action = '{{ route('gaji_komponen.destroy', ':id') }}';
        action = action.replace(':id', id);
        $('#deleteForm').attr('action', action);
    });
    </script>
@endpush
