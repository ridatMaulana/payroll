@extends('layouts.dashboard')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dark-datatable.css') }}" rel="stylesheet">
    <style>
        .modal{
            color: #000;
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
        .modal-content {
            background-color: #343a40;
            color: #fff;
        }
        .modal-header, .modal-footer {
            border-color: #454d55;
        }
        .btn-close {
            filter: invert(1);
        }
    </style>
@endpush
@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-sm-6"><h1 class="mb-0">Daftar Keluhan</h1></div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-dark table-striped table-bordered" id="keluhanTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Alasan Ditolak</th>
                        <th>Karyawan</th>
                        <th>Gaji</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($keluhans as $keluhan)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $keluhan->status }}</td>
                        <td>{{ $keluhan->keterangan }}</td>
                        <td>{{ $keluhan->alasan_ditolak }}</td>
                        <td>{{ $keluhan->gaji->karyawan->nama }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#gajiModal" data-gaji="{{ json_encode($keluhan->gaji) }}">
                                Lihat Gaji
                            </button>
                        </td>
                        <td>{{ $keluhan->created_at }}</td>
                        <td>
                            @if ($keluhan->status == 'rejected')
                                [Ditolak]
                            @elseif ($keluhan->status == 'approved')
                                [Disetujui]
                            @else
                                @if (Auth::user()->role->nama == 'Admin')
                                    <form action="{{ route('keluhan.approve', $keluhan->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                    </form>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal" data-id="{{ $keluhan->id }}">
                                        Tolak
                                    </button>
                                @else
                                    [Belum Diproses]
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Gaji Modal -->
<div class="modal fade" id="gajiModal" tabindex="-1" aria-labelledby="gajiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gajiModalLabel">Detail Gaji</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="gajiBulan"></p>
                <p id="gajiTahun"></p>
                <p id="gajiPokok"></p>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rejectForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="alasan_ditolak" class="form-label">Alasan</label>
                        <textarea name="alasan_ditolak" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
    $(document).ready(function() {
        $('#keluhanTable').DataTable();

        $('#gajiModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var gaji = JSON.parse(button.attr('data-gaji'));

            var modal = $(this);

            if (gaji) {
                var months = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                // var totalTunjangan = gaji.gajiKomponen[0].filter(k => k.komponen.tipe === 'tunjangan').reduce((sum, k) => sum + k.sub_total, 0);
                // var totalDenda = gaji.gajiKomponen[0].filter(k => k.komponen.tipe === 'denda').reduce((sum, k) => sum + k.sub_total, 0);
                // var gajiBersih = gaji.gaji_pokok + totalTunjangan - totalDenda;

                modal.find('#gajiBulan').text('Bulan: ' + months[gaji.Bulan - 1]);
                modal.find('#gajiTahun').text('Tahun: ' + gaji.Tahun);
                modal.find('#gajiPokok').text('Gaji Pokok: ' + gaji.Gaji_pokok);
            } else {
                modal.find('#gajiBulan').text('Bulan: -');
                modal.find('#gajiTahun').text('Tahun: -');
                modal.find('#gajiPokok').text('Gaji Pokok: -');
            }
        });

        $('#rejectModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var form = $('#rejectForm');
            form.attr('action', '/keluhan/reject/' + id);
        });
    });
    </script>
@endpush

