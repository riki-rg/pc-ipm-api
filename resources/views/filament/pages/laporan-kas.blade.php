<x-filament::page>
    @php
        $pengurusList = App\Models\Pengurus::orderBy('nama_lengkap')->get();
        $kas = App\Models\PembayaranKas::where('tahun', $tahun)->get()->groupBy('pengurus_id');
        $keluar = App\Models\Pengeluaran::whereYear('tanggal', $tahun)->orderBy('tanggal')->get();
        $nominalPerBulan = (int) (App\Models\PembayaranKas::where('tahun', $tahun)->value('nominal') ?: 10000);

        $namaBulan = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];

        $totalIuran = 0;
        foreach ($pengurusList as $p) {
            $lunas = ($kas[$p->id] ?? collect())->where('status', 'sudah')->count();
            $totalIuran += $lunas * $nominalPerBulan;
        }
        $totalPengeluaran = $keluar->sum('nominal');
        $saldo = $totalIuran - $totalPengeluaran;
    @endphp

    {{-- Filter tahun + tombol export --}}
    <div class="mb-6 flex flex-wrap items-center gap-4">
        <form method="GET" class="flex items-center gap-2">
            <select name="tahun" onchange="this.form.submit()"
                class="rounded-lg border border-gray-300 bg-white p-2 text-sm dark:bg-gray-900 dark:border-gray-700">
                @foreach (array_keys(tahun_options()) as $t)
                    <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
            <noscript><button type="submit" class="rounded-lg border px-3 py-2 text-sm">Tampilkan</button></noscript>
        </form>

        <a href="{{ route('filament.admin.pages.laporan-kas.export') }}?tahun={{ $tahun }}"
           class="inline-flex items-center gap-2 rounded-lg bg-success-600 px-4 py-2 text-sm font-semibold text-white hover:bg-success-700">
            <x-heroicon-o-arrow-down-tray class="h-4 w-4" />
            Export Excel
        </a>
    </div>

    {{-- Ringkasan Saldo --}}
    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
            <p class="text-sm text-gray-500">Total Penerimaan (Iuran)</p>
            <p class="mt-1 text-2xl font-bold text-success-600">Rp {{ number_format($totalIuran, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
            <p class="text-sm text-gray-500">Total Pengeluaran</p>
            <p class="mt-1 text-2xl font-bold text-danger-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
            <p class="text-sm text-gray-500">Saldo Akhir</p>
            <p class="mt-1 text-2xl font-bold {{ $saldo >= 0 ? 'text-primary-600' : 'text-danger-600' }}">
                Rp {{ number_format($saldo, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Daftar Pengeluaran --}}
    <h3 class="mb-3 text-lg font-bold">Pengeluaran Tahun {{ $tahun }}</h3>
    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="p-3 text-left text-xs font-semibold uppercase">Tanggal</th>
                    <th class="p-3 text-left text-xs font-semibold uppercase">Kategori</th>
                    <th class="p-3 text-left text-xs font-semibold uppercase">Keterangan</th>
                    <th class="p-3 text-right text-xs font-semibold uppercase">Nominal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse ($keluar as $k)
                    <tr>
                        <td class="p-3 text-sm">{{ $k->tanggal->format('d M Y') }}</td>
                        <td class="p-3 text-sm">{{ $k->kategori }}</td>
                        <td class="p-3 text-sm">{{ $k->keterangan }}</td>
                        <td class="p-3 text-right text-sm font-medium">Rp {{ number_format($k->nominal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-4 text-center text-sm text-gray-500">Belum ada pengeluaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-filament::page>
