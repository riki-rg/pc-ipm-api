<?php

namespace App\Filament\Resources\FotoGaleriResource\Pages;

use App\Filament\Resources\FotoGaleriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFotoGaleri extends EditRecord
{
    protected static string $resource = FotoGaleriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
