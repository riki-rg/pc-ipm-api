<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeriodeKepengurusanResource\Pages;
use App\Models\PeriodeKepengurusan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PeriodeKepengurusanResource extends Resource
{
    protected static ?string $model = PeriodeKepengurusan::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Sekretariat';
    protected static ?string $navigationLabel = 'Periode';
    protected static ?string $pluralLabel = 'Periode Kepengurusan';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')->label('Nama periode')->required()->maxLength(255),
            DatePicker::make('mulai')->label('Tanggal mulai')->required(),
            DatePicker::make('selesai')->label('Tanggal selesai')->required()->afterOrEqual('mulai'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('nama')->searchable()->sortable(),
            TextColumn::make('mulai')->date('d M Y')->sortable(),
            TextColumn::make('selesai')->date('d M Y')->sortable(),
            TextColumn::make('programKerja_count')->counts('programKerja')->label('Jumlah proker'),
        ])->defaultSort('mulai', 'desc')->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListPeriodeKepengurusans::route('/'), 'create' => Pages\CreatePeriodeKepengurusan::route('/create'), 'edit' => Pages\EditPeriodeKepengurusan::route('/{record}/edit')];
    }
}
