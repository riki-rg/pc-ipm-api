<?php

namespace App\Filament\Pages;

use App\Models\PembayaranKas;
use App\Models\Pengeluaran;
use App\Models\Pengurus;
use Filament\Pages\Page;

class LaporanKas extends Page
{
    protected static string $view = 'filament.pages.laporan-kas';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Keuangan';

    protected static ?string $navigationLabel = 'Laporan Kas';

    protected static ?string $title = 'Laporan Kas';

    protected static ?int $navigationSort = 4;

    public ?int $tahun = null;

    public function mount(): void
    {
        $this->tahun = (int) request('tahun', now()->year);
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->roles()->exists() ?? false;
    }

    public static function canExport(): bool
    {
        return auth()->user()?->hasAnyRole(['admin', 'bendum', 'ketum']) ?? false;
    }

    /**
     * Export laporan kas lengkap (2 sheet: Penerimaan/Iuran & Pengeluaran + Saldo)
     * dalam format SpreadsheetML (.xls) — kompatibel Excel/LibreOffice.
     */
    public static function exportExcel(?\Illuminate\Http\Request $request = null): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        abort_unless(auth()->user()?->hasAnyRole(['admin', 'bendum', 'ketum']), 403);
        $tahun = (int) ($request?->query('tahun') ?: now()->year);

        return response()->streamDownload(function () use ($tahun) {
            $namaBulan = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];

            // ===== Sheet 1: Rekap Iuran (Penerimaan) =====
            $pengurus = Pengurus::orderBy('nama_lengkap')->get();
            $kas = PembayaranKas::where('tahun', $tahun)->get()->groupBy('pengurus_id');
            $nominal = (int) (PembayaranKas::where('tahun', $tahun)->value('nominal') ?: 10000);

            $sheet1 = [];
            $h1 = ['Nama Pengurus'];
            foreach ($namaBulan as $b) { $h1[] = $b; }
            $h1[] = 'Total Lunas';
            $h1[] = 'Total Iuran (Rp)';
            $sheet1[] = $h1;

            $totalIuran = 0;
            foreach ($pengurus as $p) {
                $data = $kas[$p->id] ?? collect();
                $status = $data->pluck('status', 'bulan')->toArray();
                $lunas = $data->where('status', 'sudah')->count();
                $totalIuran += $lunas * $nominal;

                $row = [$p->nama_lengkap];
                foreach (range(1, 12) as $m) {
                    $row[] = ($status[$m] ?? 'belum') === 'sudah' ? 'Lunas' : 'Belum';
                }
                $row[] = $lunas . '/12';
                $row[] = $lunas * $nominal;
                $sheet1[] = $row;
            }
            $sheet1[] = ['TOTAL', '', '', '', '', '', '', '', '', '', '', '', '', '', $totalIuran];

            // ===== Sheet 2: Pengeluaran =====
            $keluar = Pengeluaran::whereYear('tanggal', $tahun)->orderBy('tanggal')->get();
            $totalPengeluaran = $keluar->sum('nominal');

            $sheet2 = [
                ['Tanggal', 'Kategori', 'Keterangan', 'Nominal (Rp)', 'Dicatat Oleh'],
            ];
            foreach ($keluar as $k) {
                $sheet2[] = [
                    $k->tanggal->format('d/m/Y'),
                    $k->kategori,
                    $k->keterangan,
                    $k->nominal,
                    $k->pencatat?->name ?? '-',
                ];
            }
            $sheet2[] = ['TOTAL', '', '', $totalPengeluaran, ''];

            // ===== Ringkasan =====
            $saldo = $totalIuran - $totalPengeluaran;

            // ===== Tulis SpreadsheetML =====
            echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            echo '<?mso-application progid="Excel.Sheet"?>' . "\n";
            echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">' . "\n";
            echo '<Styles>' . "\n";
            echo '<Style ss:ID="hdr"><Font ss:Bold="1"/><Interior ss:Color="#D9D9D9" ss:Pattern="Solid"/></Style>' . "\n";
            echo '<Style ss:ID="tot"><Font ss:Bold="1"/><Interior ss:Color="#F2F2F2" ss:Pattern="Solid"/></Style>' . "\n";
            echo '<Style ss:ID="title"><Font ss:Bold="1" ss:Size="14"/></Style>' . "\n";
            echo '</Styles>' . "\n";

            // --- Sheet 1: Rekap Iuran ---
            echo '<Worksheet ss:Name="Rekap Iuran ' . $tahun . '">' . "\n";
            echo '<Table>' . "\n";
            echo '<Row><Cell ss:StyleID="title"><Data ss:Type="String">Rekap Iuran Pengurus Tahun ' . $tahun . '</Data></Cell></Row>' . "\n";
            foreach ($sheet1 as $i => $row) {
                $style = '';
                if ($i === 0) { $style = ' ss:StyleID="hdr"'; }
                elseif (str_starts_with((string) $row[0], 'TOTAL')) { $style = ' ss:StyleID="tot"'; }
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

            // --- Sheet 2: Pengeluaran ---
            echo '<Worksheet ss:Name="Pengeluaran ' . $tahun . '">' . "\n";
            echo '<Table>' . "\n";
            echo '<Row><Cell ss:StyleID="title"><Data ss:Type="String">Daftar Pengeluaran Tahun ' . $tahun . '</Data></Cell></Row>' . "\n";
            foreach ($sheet2 as $i => $row) {
                $style = '';
                if ($i === 0) { $style = ' ss:StyleID="hdr"'; }
                elseif (str_starts_with((string) $row[0], 'TOTAL')) { $style = ' ss:StyleID="tot"'; }
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

            // --- Sheet 3: Ringkasan / Saldo ---
            echo '<Worksheet ss:Name="Ringkasan">' . "\n";
            echo '<Table>' . "\n";
            echo '<Row><Cell ss:StyleID="title"><Data ss:Type="String">Ringkasan Kas Tahun ' . $tahun . '</Data></Cell></Row>' . "\n";
            echo '<Row><Cell><Data ss:Type="String">Total Penerimaan (Iuran)</Data></Cell><Cell><Data ss:Type="Number">' . $totalIuran . '</Data></Cell></Row>' . "\n";
            echo '<Row><Cell><Data ss:Type="String">Total Pengeluaran</Data></Cell><Cell><Data ss:Type="Number">' . $totalPengeluaran . '</Data></Cell></Row>' . "\n";
            echo '<Row><Cell ss:StyleID="tot"><Data ss:Type="String">SALDO AKHIR</Data></Cell><Cell ss:StyleID="tot"><Data ss:Type="Number">' . $saldo . '</Data></Cell></Row>' . "\n";
            echo '</Table>' . "\n";
            echo '</Worksheet>' . "\n";
            echo '</Workbook>';
        }, "laporan-kas-{$tahun}.xls", [
            'Content-Type' => 'application/vnd.ms-excel',
        ]);
    }
}
