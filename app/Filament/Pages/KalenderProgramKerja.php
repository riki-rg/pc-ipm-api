<?php

namespace App\Filament\Pages;

use App\Models\PeriodeKepengurusan;
use App\Models\ProgramKerja;
use Carbon\CarbonImmutable;
use Filament\Pages\Page;

class KalenderProgramKerja extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Sekretariat';
    protected static ?string $navigationLabel = 'Kalender Proker';
    protected static ?string $title = 'Kalender Program Kerja';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.kalender-program-kerja';

    public string $month;
    public $periodeId = null;

    public function mount(): void
    {
        $this->month = now()->startOfMonth()->toDateString();
        $this->periodeId = PeriodeKepengurusan::query()->whereDate('mulai', '<=', now())->whereDate('selesai', '>=', now())->value('id');
    }

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->hasAnyRole(['admin', 'sekum']) ?? false;
    }

    public function previousMonth(): void
    {
        $this->month = CarbonImmutable::parse($this->month)->subMonth()->startOfMonth()->toDateString();
    }

    public function nextMonth(): void
    {
        $this->month = CarbonImmutable::parse($this->month)->addMonth()->startOfMonth()->toDateString();
    }

    protected function getViewData(): array
    {
        $first = CarbonImmutable::parse($this->month)->startOfMonth();
        $last = $first->endOfMonth();
        $programs = ProgramKerja::query()
            ->with(['bidang', 'periode'])
            ->where('mulai', '<=', $last->toDateString())
            ->where(fn ($query) => $query->whereNull('selesai')->orWhere('selesai', '>=', $first->toDateString()))
            ->when($this->periodeId, fn ($query) => $query->where('periode_id', $this->periodeId))
            ->orderBy('mulai')
            ->get();

        $cells = [];
        $offset = $first->dayOfWeekIso - 1;
        for ($i = 0; $i < $offset; $i++) {
            $cells[] = null;
        }
        for ($day = 1; $day <= $last->day; $day++) {
            $date = $first->day($day);
            $items = $programs->filter(fn (ProgramKerja $item) => $date->betweenIncluded(
                CarbonImmutable::parse($item->mulai)->startOfDay(),
                CarbonImmutable::parse($item->selesai ?? $item->mulai)->endOfDay(),
            ))->values();
            $cells[] = ['date' => $date, 'items' => $items];
        }
        while (count($cells) % 7 !== 0) {
            $cells[] = null;
        }

        return [
            'monthTitle' => $first->translatedFormat('F Y'),
            'weeks' => array_chunk($cells, 7),
            'periodes' => PeriodeKepengurusan::query()->orderByDesc('mulai')->get(),
        ];
    }
}
