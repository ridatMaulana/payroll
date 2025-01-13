<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penggajian</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Gaji Report</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Gaji Pokok</th>
                <th>Total Tunjangan</th>
                <th>Total Denda</th>
                <th>Gaji Bersih</th>
                <th>Karyawan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
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
                    <td>{{ $gaji->karyawan->nama }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
