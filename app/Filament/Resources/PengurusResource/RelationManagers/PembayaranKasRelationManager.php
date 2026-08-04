<?php

namespace App\Filament\Resources\PengurusResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class PembayaranKasRelationManager extends RelationManager
{
    protected static string $relationship = 'pembayaranKas';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bulan')->label('Bulan'),
                TextColumn::make('tahun')->label('Tahun'),
                TextColumn::make('nominal')->label('Nominal')->money('IDR', true),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'belum' => 'Belum',
                        'sudah' => 'Sudah',
                        default => '-',
                    })
                    ->colors([
                        'danger' => 'belum',
                        'success' => 'sudah',
                    ]),

                TextColumn::make('pencatat.name')->label('Dicatat Oleh'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible(fn () => auth()->user()->hasAnyRole(['developer', 'bendum'])),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()->hasAnyRole(['developer', 'bendum'])),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => auth()->user()->hasAnyRole(['developer', 'bendum'])),
            ]);
    }
}
