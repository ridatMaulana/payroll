<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }
        .slip-header, .slip-footer {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="slip-header">
        <h2>Slip Gaji</h2>
        <p>{{ $months[$gaji->Bulan] }} {{ $gaji->Tahun }}</p>
    </div>
    <div>
        <p><strong>Nama Karyawan:</strong> {{ $gaji->karyawan->nama }}</p>
        <p><strong>Jabatan:</strong> {{ $gaji->karyawan->jabatan }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Komponen</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gaji->gajiKomponen as $komponen)
                <tr>
                    <td>{{ $komponen->komponen->Nama }}</td>
                    <td>{{ ucfirst($komponen->komponen->tipe) }}</td>
                    <td>{{ $komponen->Qty }}</td>
                    <td>{{ number_format($komponen->Sub_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <p><strong>Gaji Pokok:</strong> {{ number_format($gaji->Gaji_pokok, 2) }}</p>
        <p><strong>Total Tunjangan:</strong> {{ number_format($totalTunjangan, 2) }}</p>
        <p><strong>Total Denda:</strong> {{ number_format($totalDenda, 2) }}</p>
        <p><strong>Gaji Bersih:</strong> {{ number_format($gajiBersih, 2) }}</p>
    </div>
    <div class="slip-footer">
        <p>Terima kasih atas kontribusi Anda.</p>
    </div>
</body>
</html>
