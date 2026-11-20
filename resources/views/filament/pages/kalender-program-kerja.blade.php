<x-filament-panels::page>
    <div class="space-y-5">
        <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
            <div class="flex items-center gap-2">
                <x-filament::button icon="heroicon-o-chevron-left" color="gray" wire:click="previousMonth" aria-label="Bulan sebelumnya" />
                <h2 class="min-w-40 text-center text-lg font-semibold text-gray-950 dark:text-white">{{ $monthTitle }}</h2>
                <x-filament::button icon="heroicon-o-chevron-right" color="gray" wire:click="nextMonth" aria-label="Bulan berikutnya" />
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <select wire:model.live="periodeId" class="rounded-lg border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-800">
                    <option value="">Semua periode</option>
                    @foreach ($periodes as $periode)
                        <option value="{{ $periode->id }}">{{ $periode->nama }}</option>
                    @endforeach
                </select>
                <x-filament::button tag="a" href="{{ \App\Filament\Resources\ProgramKerjaResource::getUrl('create') }}" icon="heroicon-o-plus">Tambah program kerja</x-filament::button>
            </div>
        </div>

        <div class="grid grid-cols-7 overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                <div class="border-b border-gray-200 bg-gray-50 px-2 py-3 text-center text-xs font-semibold text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">{{ $day }}</div>
            @endforeach
            @foreach ($weeks as $week)
                @foreach ($week as $cell)
                    <div class="min-h-28 border-b border-r border-gray-100 p-2 dark:border-gray-800">
                        @if ($cell)
                            <div class="mb-1 text-xs font-semibold {{ $cell['date']->isToday() ? 'text-primary-600' : 'text-gray-500 dark:text-gray-400' }}">{{ $cell['date']->day }}</div>
                            <div class="space-y-1">
                                @foreach ($cell['items'] as $item)
                                    <a href="{{ \App\Filament\Resources\ProgramKerjaResource::getUrl('edit', ['record' => $item->id]) }}" class="block rounded-md bg-primary-50 px-2 py-1 text-xs text-primary-800 hover:bg-primary-100 dark:bg-primary-950 dark:text-primary-200" title="{{ $item->nama }} — {{ $item->bidang?->nama ?? 'Lintas bidang' }}">
                                        <span class="font-medium">{{ $item->nama }}</span>
                                        <span class="block opacity-75">{{ $item->bidang?->nama ?? 'Lintas bidang' }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
