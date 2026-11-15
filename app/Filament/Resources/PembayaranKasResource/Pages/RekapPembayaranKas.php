<?php

namespace App\Filament\Resources\PembayaranKasResource\Pages;

use App\Filament\Resources\PembayaranKasResource;
use Filament\Resources\Pages\Page;
use App\Models\Pengurus;
use App\Models\PembayaranKas;
use Illuminate\Support\Facades\DB;

class RekapPembayaranKas extends Page
{
    protected static string $resource = PembayaranKasResource::class;

    protected static string $view = 'filament.resources.pembayaran-kas-resource.pages.rekap-pembayaran-kas';

    protected static ?string $title = 'Rekap Pembayaran Kas';

    public array $rekap = [];

    public function mount()
    {
        $tahun = now()->year;

        $pengurus = Pengurus::orderBy('nama_lengkap')->get();

        foreach ($pengurus as $p) {
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $kas = PembayaranKas::where('pengurus_id', $p->id)
                    ->where('tahun', $tahun)
                    ->where('bulan', $bulan)
                    ->first();

                $this->rekap[$p->id][$bulan] = $kas?->status === 'sudah';
            }
        }
    }

    public function saveAll()
    {
        $tahun = now()->year;

        DB::transaction(function () use ($tahun) {
            foreach ($this->rekap as $pengurusId => $bulanData) {
                foreach ($bulanData as $bulan => $checked) {
                    PembayaranKas::updateOrCreate(
                        [
                            'pengurus_id' => $pengurusId,
                            'tahun' => $tahun,
                            'bulan' => $bulan,
                        ],
                        [
                            'status' => $checked ? 'sudah' : 'belum',
                            'nominal' => 10000,
                        ]
                    );
                }
            }
        });

        $this->dispatch('saved'); // filament toast
    }

    public function generateKas()
    {
        $tahun = now()->year;
        $pengurus = Pengurus::all();

        foreach ($pengurus as $p) {
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                PembayaranKas::firstOrCreate(
                    [
                        'pengurus_id' => $p->id,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                    ],
                    [
                        'status' => 'belum',
                        'nominal' => 10000,
                    ]
                );
            }
        }

        $this->mount();
        $this->dispatch('generated');
    }
}
