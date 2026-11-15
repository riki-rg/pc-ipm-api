<?php

namespace App\Filament\Resources\PembayaranKasResource\Pages;

use App\Filament\Resources\PembayaranKasResource;
use Filament\Resources\Pages\ListRecords;

class ListPembayaranKas extends ListRecords
{
    protected static string $resource = PembayaranKasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
