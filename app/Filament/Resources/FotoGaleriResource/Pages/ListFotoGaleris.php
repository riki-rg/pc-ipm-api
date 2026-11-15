<?php

namespace App\Filament\Resources\FotoGaleriResource\Pages;

use App\Filament\Resources\FotoGaleriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFotoGaleris extends ListRecords
{
    protected static string $resource = FotoGaleriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
