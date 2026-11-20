<?php

namespace App\Filament\Resources\PembayaranKasResource\Pages;

use App\Filament\Resources\PembayaranKasResource;
use Filament\Resources\Pages\Page;
use App\Models\Pengurus;
use App\Models\PembayaranKas;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RekapPembayaranKas extends Page
{
    protected static string $resource = PembayaranKasResource::class;

    protected static string $view = 'filament.resources.pembayaran-kas-resource.pages.rekap-pembayaran-kas';

    protected static ?string $title = 'Rekap Pembayaran Kas';

    public array $rekap = [];

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->hasAnyRole(['admin', 'bendum']) ?? false;
    }

    private function authorizeKasManagement(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(['admin', 'bendum']), 403);
    }

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
        $this->authorizeKasManagement();
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
        $this->authorizeKasManagement();
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

    /**
     * Export rekap kas ke Excel (.xlsx) via SpreadsheetML sederhana yang
     * kompatibel dengan Excel/LibreOffice tanpa dependensi eksternal.
     */
    public function exportExcel()
    {
        $this->authorizeKasManagement();
        $tahun = now()->year;

        return response()->streamDownload(function () use ($tahun) {
            $namaBulan = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
            ];

            // 1. Ekstrak XLSX (zip) tanpa ZipArchive? Tidak — pakai pendekatan
            //    XML Spreadsheet 2003 (SpreadsheetML) yang dikenali Excel.
            $rows = [];

            // Header
            $header = ['Nama Pengurus'];
            foreach ($namaBulan as $b) {
                $header[] = $b;
            }
            $header[] = 'Total Lunas';
            $header[] = 'Total Iuran (Rp)';
            $rows[] = $header;

            // Data
            $pengurus = Pengurus::orderBy('nama_lengkap')->get();
            $kas = PembayaranKas::where('tahun', $tahun)->get()->groupBy('pengurus_id');
            $nominalPerBulan = (int) (PembayaranKas::where('tahun', $tahun)->value('nominal') ?: 10000);

            foreach ($pengurus as $p) {
                $data = $kas[$p->id] ?? collect();
                $status = $data->pluck('status', 'bulan')->toArray();
                $countLunas = $data->where('status', 'sudah')->count();

                $row = [$p->nama_lengkap];
                foreach (range(1, 12) as $m) {
                    $row[] = ($status[$m] ?? 'belum') === 'sudah' ? 'Lunas' : 'Belum';
                }
                $row[] = $countLunas . '/12';
                $row[] = $countLunas * $nominalPerBulan;
                $rows[] = $row;
            }

            // Baris total
            $totals = ['TOTAL'];
            foreach (range(1, 12) as $m) {
                $c = 0;
                foreach ($pengurus as $p) {
                    $data = $kas[$p->id] ?? collect();
                    if (($data->pluck('status', 'bulan')[$m] ?? 'belum') === 'sudah') {
                        $c++;
                    }
                }
                $totals[] = $c . ' org';
            }
            $totals[] = '';
            $totals[] = array_sum(array_map(fn ($r) => (int) end($r), $rows));
            $rows[] = $totals;

            // SpreadsheetML 2003 (XML) — dikenali Excel & LibreOffice, satu file
            echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            echo '<?mso-application progid="Excel.Sheet"?>' . "\n";
            echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"' . "\n";
            echo ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">' . "\n";
            echo '<Styles>' . "\n";
            echo '<Style ss:ID="hdr"><Font ss:Bold="1"/><Interior ss:Color="#D9D9D9" ss:Pattern="Solid"/></Style>' . "\n";
            echo '<Style ss:ID="tot"><Font ss:Bold="1"/><Interior ss:Color="#F2F2F2" ss:Pattern="Solid"/></Style>' . "\n";
            echo '</Styles>' . "\n";
            echo '<Worksheet ss:Name="Rekap Kas ' . $tahun . '">' . "\n";
            echo '<Table>' . "\n";

            foreach ($rows as $i => $row) {
                $style = ($i === 0 || str_starts_with((string) $row[0], 'TOTAL')) ? ' ss:StyleID="hdr"' : '';
                if ($i === 0) {
                    $style = ' ss:StyleID="hdr"';
                } elseif (str_starts_with((string) $row[0], 'TOTAL')) {
                    $style = ' ss:StyleID="tot"';
                }
                echo '<Row>' . "\n";
                foreach ($row as $cell) {
                    $isNum = is_int($cell) || is_float($cell);
                    $type = $isNum ? 'Number' : 'String';
                    echo '<Cell' . $style . '><Data ss:Type="' . $type . '">' . htmlspecialchars((string) $cell, ENT_XML1) . '</Data></Cell>' . "\n";
                }
                echo '</Row>' . "\n";
            }

            echo '</Table>' . "\n";
            echo '</Worksheet>' . "\n";
            echo '</Workbook>';
        }, "rekap-kas-{$tahun}.xls", [
            'Content-Type' => 'application/vnd.ms-excel',
        ]);
    }
}
