<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kamar;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Total kamar dari tabel kamars
        $totalKamar = Kamar::count();

        // Kamar yang sedang terisi = punya reservasi aktif hari ini
        $kamarTerisi = Reservasi::whereDate('tanggal_checkin', '<=', $today)
                        ->whereDate('tanggal_checkout', '>', $today)
                        ->whereNotIn('status', ['selesai'])
                        ->distinct('kamar_id')
                        ->count('kamar_id');

        // Okupansi dalam persen
        $okupansi = $totalKamar > 0
                        ? round(($kamarTerisi / $totalKamar) * 100)
                        : 0;

        // Check-in hari ini
        $checkInHariIni = Reservasi::whereDate('tanggal_checkin', $today)
                            ->whereNotIn('status', ['selesai'])
                            ->count();

        // Check-out hari ini
        $checkOutHariIni = Reservasi::whereDate('tanggal_checkout', $today)
                            ->where('status', 'selesai')
                            ->count();

        // Kamar tersedia = total kamar dikurangi yang terisi
        $kamarTersedia = $totalKamar - $kamarTerisi;

        return view('welcome', compact(
            'okupansi',
            'checkInHariIni',
            'checkOutHariIni',
            'kamarTersedia',
            'totalKamar'
        ));
    }
}