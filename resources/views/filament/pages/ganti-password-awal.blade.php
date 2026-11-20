<x-filament-panels::page>
    <div class="mx-auto w-full max-w-xl space-y-6">
        <p class="text-sm text-gray-600 dark:text-gray-300">Untuk keamanan akun, ganti kata sandi sementara sebelum melanjutkan.</p>
        <form wire:submit="save" class="space-y-6">
            {{ $this->form }}
            <div class="flex flex-wrap gap-3">
                <x-filament::button type="submit">Simpan kata sandi baru</x-filament::button>
                <x-filament::button type="button" color="gray" wire:click="logout">Keluar</x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>
