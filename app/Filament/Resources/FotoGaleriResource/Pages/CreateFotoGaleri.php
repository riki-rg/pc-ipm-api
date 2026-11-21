<?php

namespace App\Filament\Resources\FotoGaleriResource\Pages;

use App\Filament\Resources\FotoGaleriResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFotoGaleri extends CreateRecord
{
    protected static string $resource = FotoGaleriResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
