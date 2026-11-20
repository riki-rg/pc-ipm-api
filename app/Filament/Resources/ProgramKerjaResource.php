<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramKerjaResource\Pages;
use App\Models\Bidang;
use App\Models\PeriodeKepengurusan;
use App\Models\ProgramKerja;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProgramKerjaResource extends Resource
{
    protected static ?string $model = ProgramKerja::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Sekretariat';
    protected static ?string $navigationLabel = 'Data Program Kerja';
    protected static ?string $pluralLabel = 'Program Kerja';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('periode_id')->label('Periode kepengurusan')->options(fn () => PeriodeKepengurusan::query()->orderByDesc('mulai')->pluck('nama', 'id'))->required()->searchable(),
            TextInput::make('nama')->label('Program kerja')->required()->maxLength(255),
            Select::make('bidang_id')->label('Bidang penanggung jawab')->options(fn () => Bidang::query()->orderBy('nama')->pluck('nama', 'id'))->nullable()->searchable(),
            DatePicker::make('mulai')->label('Tanggal mulai')->required(),
            DatePicker::make('selesai')->label('Tanggal selesai')->afterOrEqual('mulai'),
            Select::make('status')->options(['Rencana' => 'Rencana', 'Berjalan' => 'Berjalan', 'Selesai' => 'Selesai', 'Ditunda' => 'Ditunda'])->default('Rencana')->required(),
            Textarea::make('catatan')->rows(3)->columnSpanFull(),
            TextInput::make('gdrive_url')->label('Tautan Google Drive')->url()->maxLength(2048)->rule('regex:/^https:\/\/(drive|docs)\.google\.com\//i'),
            TextInput::make('lokasi_fisik')->label('Lokasi arsip fisik')->maxLength(255),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('periode.nama')->label('Periode')->sortable(),
            TextColumn::make('nama')->label('Program kerja')->searchable()->sortable(),
            TextColumn::make('bidang.nama')->label('Bidang')->placeholder('Lintas bidang')->sortable(),
            TextColumn::make('mulai')->date('d M Y')->sortable(),
            TextColumn::make('selesai')->date('d M Y')->placeholder('—')->sortable(),
            TextColumn::make('status')->badge()->sortable(),
            TextColumn::make('gdrive_url')->label('Drive')->url(fn ($record) => $record->gdrive_url, true)->placeholder('—'),
        ])->defaultSort('mulai')->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListProgramKerjas::route('/'), 'create' => Pages\CreateProgramKerja::route('/create'), 'edit' => Pages\EditProgramKerja::route('/{record}/edit')];
    }
}
