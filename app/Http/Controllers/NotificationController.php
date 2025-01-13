<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Gaji;
use App\Models\GajiKomponen;

class NotificationController extends Controller
{
    public function sendManagerNotification($no, $name, $gaji)
    {
        $message = "Rincian Gaji\n";
        $message .= "Nama: {$gaji->karyawan->nama}\n";
        $message .= "Periode: " . \Carbon\Carbon::createFromDate($gaji->Tahun, $gaji->Bulan, 1)->locale('id')->isoFormat('MMMM YYYY') . "\n";
        $message .= "Gaji Pokok: " . number_format($gaji->Gaji_pokok, 2) . "\n";

        $totalTunjangan = $gaji->gajiKomponen->where('komponen.tipe', 'tunjangan')->sum('Sub_total');
        $totalDenda = $gaji->gajiKomponen->where('komponen.tipe', 'denda')->sum('Sub_total');
        $gajiBersih = $gaji->Gaji_pokok + $totalTunjangan - $totalDenda;

        $message .= "\nRincian Tunjangan:\n";
        foreach ($gaji->gajiKomponen->where('komponen.tipe', 'tunjangan') as $tunjangan) {
            $message .= "- {$tunjangan->komponen->Nama}: " . number_format($tunjangan->Sub_total, 2) . "\n";
        }

        $message .= "\nRincian Denda:\n";
        foreach ($gaji->gajiKomponen->where('komponen.tipe', 'denda') as $denda) {
            $message .= "- {$denda->komponen->Nama}: " . number_format($denda->Sub_total, 2) . "\n";
        }

        $message .= "\nTotal Tunjangan: " . number_format($totalTunjangan, 2) . "\n";
        $message .= "Total Denda: " . number_format($totalDenda, 2) . "\n";
        $message .= "Gaji Bersih: " . number_format($gajiBersih, 2) . "\n";

        $apiKey = "3abf5e3009fe98a27ab1524398ddc29fb7f43f29";//3abf5e3009fe98a27ab1524398ddc29fb7f43f29 //1462dfca3fca5b6775d193c6bd5bb6104c2c7faf
        $url = 'https://core-blast.asqi.co.id/api/send-message';

        $data = [
            'code' => $apiKey,
            'penerima' => [
                [
                    'name' => $name,
                    'phone' => $no
                ]
            ],
            'message_type' => 1,
            'message_schedule' => 1,
            'file' => '',
            'pesan' => $message,
            'delay' => 8000
        ];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post($url, $data);

        if ($response->ok()) {
            $status = True;
            $keterangan = 'Berhasil mengirim pesan WhatsApp';
        } else {
            $status = False;
            $keterangan = 'Gagal mengirim pesan WhatsApp';
        }

        Notification::create([
            'keterangan' => $keterangan,
            'status' => $status,
            'tipe' => 'Gaji',
            'gajis_id' => $gaji->id,
        ]);

    }

    public function showSendNotificationForm()
    {
        $gajis = Gaji::with('karyawan')->get();
        return view('notification.send', compact('gajis'));
    }

    public function sendNotifications(Request $request)
    {
        $gajiIds = $request->input('gaji_ids');
        foreach ($gajiIds as $gajiId) {
            $gaji = Gaji::with('karyawan', 'gajiKomponen.komponen')->find($gajiId);
            $this->sendManagerNotification($gaji->karyawan->no_wa, $gaji->karyawan->nama, $gaji);
        }
        return redirect()->route('notification.index')->with('success', 'Notifications sent successfully.');
    }

    public function index()
    {
        $notifications = Notification::with(['gaji.karyawan'])->get();
        return view('notification.index', compact('notifications'));
    }
}
