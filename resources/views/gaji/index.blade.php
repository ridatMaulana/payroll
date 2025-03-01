@extends('layouts.dashboard')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dark-datatable.css') }}" rel="stylesheet">
    <style>
        .modal{
            color: #000;
        }
        .modal-content {
            background-color: #343a40; /* Dark background */
            color: #fff; /* White text */
        }
        .btn-close {
            filter: invert(1); /* Make the close button icon white */
        }
        .table-responsive {
            overflow-x: auto;
        }
        @media (max-width: 768px) {
            .table-responsive {
                margin-bottom: 15px;
            }
            .btn {
                margin-bottom: 10px;
            }
        }
    </style>
@endpush
@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-sm-6"><h1 class="mb-0">{{ request()->is('slip-gaji/*') ? 'Slip ' : '' }}Gaji</h1></div>
        <div class="col-sm-6 text-end">
            @if (Auth::user()->role->nama == 'Admin' && request()->is('gaji/*'))
                <a href="{{ route('gaji.create') }}" class="btn btn-primary">Tambah Data</a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">Import Data</button>
            @endif
            @if (request()->is('gaji/*'))
                <a href="{{ route('gaji.print') }}" class="btn btn-secondary">Download PDF</a>
            @endif
            {{-- <button type="button" class="btn btn-secondary" onclick="downloadPDF()">Download PDF</button> --}}
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-dark table-striped table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Gaji Pokok</th>
                        <th>Total Tunjangan</th>
                        <th>Total Denda</th>
                        <th>Gaji Bersih</th>
                        @if (request()->is('gaji/*'))
                        <th>Karyawan</th>
                        @endif
                        @if (Auth::user()->role->nama == 'Admin' | request()->is('slip-gaji/*'))
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    $months = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                    @endphp
                    @foreach ($gajis as $gaji)
                    @php
                        $totalTunjangan = $gaji->gajiKomponen->where('komponen.tipe', 'tunjangan')->sum('Sub_total');
                        $totalDenda = $gaji->gajiKomponen->where('komponen.tipe', 'denda')->sum('Sub_total');
                        $gajiBersih = $gaji->Gaji_pokok + $totalTunjangan - $totalDenda;
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $months[$gaji->Bulan] }}</td>
                        <td>{{ $gaji->Tahun }}</td>
                        <td>{{ $gaji->Gaji_pokok }}</td>
                        <td>{{ $totalTunjangan }}</td>
                        <td>{{ $totalDenda }}</td>
                        <td>{{ $gajiBersih }}</td>
                        @if (request()->is('gaji/*'))
                        <td>{{ $gaji->karyawan->nama }}</td>
                        @endif
                        @if (Auth::user()->role->nama == 'Admin' && request()->is('gaji/*'))
                        <td>
                            <a href="{{ route('gaji.edit', $gaji->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('gaji.destroy', $gaji->id) }}" method="POST" style="display:inline-block;" onsubmit="return false;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $gaji->id }}">Hapus</button>
                            </form>
                            <a href="{{ route('gaji_komponen.show', ['gaji_id' => $gaji->id]) }}" class="btn btn-info btn-sm">Komponen</a>
                        </td>
                        @elseif (Auth::user()->role->nama == 'Karyawan' && request()->is('slip-gaji/*'))
                        <td>
                            <a href="{{ route('slip-gaji.print', ['gaji_id' => $gaji->id]) }}" class="btn btn-secondary btn-sm">Print Slip</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#keluhanModal" data-id="{{ $gaji->id }}">Ajukan Keluhan</button>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data Gaji</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('gaji.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Import</button>
                </form>
            </div>
        </div>
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

<!-- Keluhan Modal -->
<div class="modal fade" id="keluhanModal" tabindex="-1" aria-labelledby="keluhanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="keluhanModalLabel">Ajukan Keluhan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('keluhan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" required></textarea>
                    </div>
                    <input type="hidden" name="gajis_id" id="gajis_id">
                    <button type="submit" class="btn btn-primary">Ajukan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.4/purify.min.js"></script> <!-- Include dompurify from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script> <!-- Include html2canvas from CDN -->
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });

    async function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'potrait',
            unit: 'pt',
            format: 'a4'
        });

        // Destroy DataTable instance
        $('#myTable').DataTable().destroy();

        var table = document.getElementById('myTable').cloneNode(true);
        var aksiIndex = Array.from(table.rows[0].cells).findIndex(cell => cell.innerText === 'Aksi');

        for (var i = 0; i < table.rows.length; i++) {
            table.rows[i].deleteCell(aksiIndex);
        }

        var html = table.outerHTML;
        var cleanHtml = DOMPurify.sanitize(html); // Use DOMPurify to sanitize the HTML

        doc.html(cleanHtml, {
            callback: function (doc) {
                doc.save('gaji.pdf');
            },
            x: 10,
            y: 10,
            html2canvas: {
                scale: 1 // Adjust the scale to fit content within a single page
            }
        });

        // Reinitialize DataTable
        $('#myTable').DataTable();
    }

    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var action = '{{ route('gaji.destroy', ':id') }}';
        action = action.replace(':id', id);
        $('#deleteForm').attr('action', action);
    });

    $('#keluhanModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        modal.find('#gajis_id').val(id);
    });
    </script>
@endpush
