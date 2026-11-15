<?php

namespace App\Filament\Resources\PembayaranKasResource\Pages;

use App\Filament\Resources\PembayaranKasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembayaranKas extends EditRecord
{
    protected static string $resource = PembayaranKasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
