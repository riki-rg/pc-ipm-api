<x-filament::page>
    <h2 class="text-xl font-bold mb-6">Rekap Pembayaran Kas</h2>

    @php
        use App\Models\PembayaranKas;
        use App\Models\Pengurus;

        // Ambil semua pengurus
        $pengurusList = Pengurus::orderBy('nama_lengkap')->get();

        // Ambil tahun aktif
        $tahun = request('tahun', now()->year);

        // Ambil data kas per tahun
        $kas = PembayaranKas::where('tahun', $tahun)->get()->groupBy('pengurus_id');

        $namaBulan = [
            1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',
            7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'
        ];
    @endphp

    {{-- PILIH TAHUN --}}
    <form method="GET" class="mb-4">
        <select name="tahun" onchange="this.form.submit()" class="border rounded p-2">
            @foreach (range(now()->year - 1, now()->year + 1) as $t)
                <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>
                    {{ $t }}
                </option>
            @endforeach
        </select>
    </form>

    <table class="min-w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Pengurus</th>
                @foreach ($namaBulan as $key => $bln)
                    <th class="border p-2">{{ $bln }}</th>
                @endforeach
                <th class="border p-2">Total Lunas</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($pengurusList as $p)
                @php
                    $data = $kas[$p->id] ?? collect();
                    $status = $data->pluck('status', 'bulan')->toArray();

                    $countLunas = $data->where('status','sudah')->count();
                @endphp

                <tr>
                    <td class="border p-2 font-medium">{{ $p->nama_lengkap }}</td>

                    @foreach (range(1,12) as $m)
                        <td class="border p-2 text-center">
                            @if (isset($status[$m]) && $status[$m] === 'sudah')
                                <span class="text-green-600 font-bold">✔</span>
                            @else
                                <span class="text-red-600 font-bold">✘</span>
                            @endif
                        </td>
                    @endforeach

                    <td class="border p-2 text-center">
                        {{ $countLunas }}/12
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-filament::page>
