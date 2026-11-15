<?php

namespace App\Filament\Resources\AlbumGaleriResource\Pages;

use App\Filament\Resources\AlbumGaleriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlbumGaleris extends ListRecords
{
    protected static string $resource = AlbumGaleriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
