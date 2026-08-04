<?php

namespace App\Filament\Pages;

use App\Models\Pengurus;
use App\Models\PembayaranKas;
use Filament\Pages\Page;
use Filament\Panel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class InputPembayaranKas extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static string $view = 'filament.pages.input-pembayaran-kas';
    protected static ?string $navigationLabel = 'Input Pembayaran Kas';
    protected static ?string $title = 'Input Pembayaran Kas';
    protected static ?string $slug = 'input-pembayaran-kas';
    //protected $table = 'pembayaran_kas';

    /**
     * DAFTAR ROUTE KHUSUS PAGE INI
     */


    /**
     * SIMPAN SEMUA DATA
     */
    /*public static function saveAll(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $statuses = $request->status ?? [];

        foreach ($statuses as $pengurusId => $isChecked) {
            PembayaranKas::updateOrCreate(
                [
                    'pengurus_id' => $pengurusId,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ],
                [
                    'status' => $isChecked ? 'sudah' : 'belum',
                    'nominal' => PembayaranKas::NOMINAL_KAS,
                    'user_id_pencatat' => auth()->id(),
                ]
            );
        }

        session()->flash('success', 'Data berhasil disimpan!');
        return back();
    }*/

    /*public function saveAll()
    {
        $bulan = request('bulan');
        $tahun = request('tahun');
        $status = request('status', []);
        $metode = request('metode', []);

        foreach ($status as $pengurusId => $checked) {
            if ($checked != 1) {
                continue; // skip yang tidak diceklis
            }

            // metode bayar wajib
            if (!isset($metode[$pengurusId]) || $metode[$pengurusId] === null) {
                continue;
            }

            PembayaranKas::updateOrCreate(
                [
                    'pengurus_id' => $pengurusId,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ],
                [
                    'status' => 'sudah',
                    'metode_bayar' => $metode[$pengurusId],
                    'nominal' => 5000, // ganti sesuai aturan lo
                    'user_id_pencatat' => auth()->id(),
                ]
            );
        }

        session()->flash('success', 'Data pembayaran kas berhasil disimpan!');
        return redirect()->back();
    }*/

    public function saveAll()
    {
        $statuses = $request->input('status', []);
        $metodes = $request->input('metode_bayar', []);

        foreach ($statuses as $pengurusId => $isChecked) {

            // Kalau ga dicentang → skip
            if (!$isChecked) {
                continue;
            }

            $metode = $metodes[$pengurusId] ?? null;

            PembayaranKas::updateOrCreate(
                [
                    'pengurus_id' => $pengurusId,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ],
                [
                    'status' => 'sudah',
                    'nominal' => PembayaranKas::NOMINAL_KAS,
                    'metode_bayar' => $metode,
                    'user_id_pencatat' => auth()->id(),
                ]
            );
        }
    }
    /**
     * DATA UNTUK BLADE
     */
    public function getData(): array
    {
        $bulan = request('bulan', now()->month);
        $tahun = request('tahun', now()->year);

        // Ambil semua pengurus
        $penguruses = Pengurus::orderBy('nama_lengkap')->get();

        // Ambil data kas kalau ada
        $kas = PembayaranKas::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get()
            ->keyBy('pengurus_id');

        return [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'penguruses' => $penguruses,
            'kas' => $kas,
        ];
    }
}
