<?php

namespace App\Filament\Resources\ArsipRapatResource\Pages;

use App\Filament\Resources\ArsipRapatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArsipRapat extends ListRecords
{
    protected static string $resource = ArsipRapatResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
