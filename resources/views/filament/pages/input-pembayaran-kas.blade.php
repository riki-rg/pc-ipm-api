<x-filament::page>
    @php
        $data = $this->getData();
        $tahun = $data['tahun'] ?? now()->year;
        $bulan = $data['bulan'] ?? now()->month;
        $pengurus = $data['pengurus'] ?? collect();
        $kas = $data['kas'] ?? collect();
    @endphp

    <h2 class="text-xl font-bold mb-6">Input Pembayaran Kas - Bulan: {{ $bulan }} / Tahun: {{ $tahun }}</h2>

    <form method="POST" action="{{ route('filament.admin.pages.inputPembayaranKas.saveAll') }}">
        @csrf

        {{-- FILTER --}}
        <div class="mb-6 bg-white p-4 rounded-lg border shadow-sm flex flex-col md:flex-row gap-4 items-center">
            <div>
                <label class="block mb-1 font-medium">Pilih Bulan</label>
                <select name="bulan" class="border rounded-lg p-2 w-40">
                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}" {{ $m == $bulan ? 'selected' : '' }}>
                            {{ \Illuminate\Support\Arr::get([
                                1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                                7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
                            ], $m) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Pilih Tahun</label>
                <select name="tahun" class="border rounded-lg p-2 w-32">
                    @foreach(range(now()->year-1, now()->year+1) as $t)
                        <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white p-4 rounded-lg border shadow-sm">
            <table class="min-w-full border mb-4">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2 text-left">#</th>
                        <th class="border p-2 text-left">Nama</th>
                        <th class="border p-2 text-center">Bayar</th>
                        <th class="border p-2 text-center">Metode</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pengurus as $p)
                        <tr>
                            <td class="border p-2">{{ $loop->iteration }}</td>
                            <td class="border p-2">{{ $p->nama_lengkap }}</td>

                            <td class="border p-2 text-center">
                                <input type="hidden" name="status[{{ $p->id }}]" value="0">
                                <input type="checkbox" name="status[{{ $p->id }}]" value="1" {{ $checked ? 'checked' : '' }}>

                                <select name="metode_bayar[{{ $p->id }}]" class="border rounded p-1 ml-2">
                                    <option value="">--pilih--</option>
                                    <option value="cash" {{ ($exists->metode_bayar ?? '') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="transfer" {{ ($exists->metode_bayar ?? '') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                    <option value="kajian bulanan" {{ ($exists->metode_bayar ?? '') == 'kajian bulanan' ? 'selected' : '' }}>Kajian Bulanan</option>
                                </select>
                            </td>


                            <td class="border p-2 text-center">
                                <select name="metode[{{ $p->id }}]" class="border rounded p-1">
                                    <option value="">Pilih…</option>
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="kajian bulanan">Kajian Bulanan</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        {{-- BUTTONS --}}
        <div class="flex gap-3 mt-6">
            <button 
                type="submit" 
                class="px-5 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow-sm transition"
            >
                Simpan Semua
            </button>

            <a 
                href="{{ url()->current() }}" 
                class="px-5 py-2 border rounded-lg hover:bg-gray-100 transition"
            >
                Refresh
            </a>
        </div>
    </form>

    {{-- SUCCESS MESSAGE --}}
    @if(session()->has('success'))
        <div class="mt-4 text-green-700 font-medium bg-green-50 border border-green-200 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif
</x-filament::page>
