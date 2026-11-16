<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesanMasukResource\Pages;
use App\Models\PesanMasuk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

// app/Filament/Resources/PesanMasukResource.php
class PesanMasukResource extends Resource
{
    protected static ?string $model = PesanMasuk::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox';
    protected static ?string $navigationGroup = 'Interaksi';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Pesan Masuk';

    // Kita gak butuh FORM (karena admin cuma baca, gak nginput)
    // Tapi kalau mau liat detail, bisa pake ViewAction
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable(),
                TextColumn::make('email')->copyable(),
                TextColumn::make('pesan')->limit(50),
                TextColumn::make('created_at')->label('Diterima')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc') // Pesan baru di atas
            ->actions([
                Tables\Actions\DeleteAction::make(), // Hapus pesan spam
            ]);
    }
    
    // Gak perlu pages Create/Edit
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanMasuks::route('/'),
        ];
    }
    
    public static function canCreate(): bool
    {
       return false; // Admin gak boleh bikin pesan sendiri
    }
}
