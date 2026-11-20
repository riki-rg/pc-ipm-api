<?php

namespace App\Filament\Resources\KajianResource\Pages;

use App\Filament\Resources\KajianResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKajian extends CreateRecord
{
    protected static string $resource = KajianResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
