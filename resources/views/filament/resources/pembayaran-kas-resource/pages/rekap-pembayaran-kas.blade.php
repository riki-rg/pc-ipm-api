<x-filament::page>
    <h2 class="mb-6 text-xl font-semibold text-[#0b3d2e] dark:text-white">Rekap Pembayaran Kas</h2>

    @php
        // Ambil semua pengurus
        $pengurusList = \App\Models\Pengurus::orderBy('nama_lengkap')->get();

        // Ambil tahun aktif
        $tahun = request('tahun', now()->year);

        // Ambil data kas per tahun
        $kas = \App\Models\PembayaranKas::where('tahun', $tahun)->get()->groupBy('pengurus_id');

        $namaBulan = [
            1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',
            7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'
        ];
    @endphp

    {{-- PILIH TAHUN + EXPORT --}}
    <form method="GET" class="mb-4 flex items-center gap-4">
        <select name="tahun" onchange="this.form.submit()" class="min-w-[5.5rem] rounded-lg border border-gray-300 bg-white px-3 py-2 pr-8 text-sm dark:bg-gray-900 dark:border-gray-700">
            @foreach (array_keys(tahun_options()) as $t)
                <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>
                    {{ $t }}
                </option>
            @endforeach
        </select>

        <a href="{{ route('filament.admin.resources.pembayaran-kas.rekap.export') }}?tahun={{ $tahun }}"
           class="pcipm-action-button inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Export Excel
        </a>
    </form>

    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
        <table class="w-full min-w-[760px] divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr class="bg-gray-100">
                <th class="border p-2 text-left text-xs font-semibold uppercase">Pengurus</th>
                @foreach ($namaBulan as $key => $bln)
                    <th class="border p-2 text-center text-xs font-semibold uppercase">{{ $bln }}</th>
                @endforeach
                <th class="border p-2 text-center text-xs font-semibold uppercase">Total Lunas</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($pengurusList as $p)
                @php
                    $data = $kas[$p->id] ?? collect();
                    $status = $data->pluck('status', 'bulan')->toArray();

                    $countLunas = $data->where('status','sudah')->count();
                @endphp

                <tr class="border-b border-gray-100 hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800">
                    <td class="border p-2 text-sm font-medium">{{ $p->nama_lengkap }}</td>

                    @foreach (range(1,12) as $m)
                        <td class="border p-2 text-center text-sm">
                            @if (isset($status[$m]) && $status[$m] === 'sudah')
                                <span class="text-green-600 font-bold">✔</span>
                            @else
                                <span class="text-red-600 font-bold">✘</span>
                            @endif
                        </td>
                    @endforeach

                    <td class="border p-2 text-center text-sm">
                        {{ $countLunas }}/12
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>

</x-filament::page>
