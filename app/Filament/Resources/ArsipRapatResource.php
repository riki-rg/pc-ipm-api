<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArsipRapatResource\Pages;
use App\Models\ArsipRapat;
use App\Models\Bidang;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Table;

class ArsipRapatResource extends Resource
{
    protected static ?string $model = ArsipRapat::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Sekretariat';
    protected static ?string $navigationLabel = 'Arsip Rapat';
    protected static ?string $pluralLabel = 'Arsip Rapat';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('judul')->label('Judul rapat')->required()->maxLength(255),
            Select::make('kategori')->options([
                'Rapat Pimpinan' => 'Rapat Pimpinan',
                'Rapat Bidang' => 'Rapat Bidang',
                'Rapat Koordinasi' => 'Rapat Koordinasi',
                'Rapat Umum' => 'Rapat Umum',
                'Lainnya' => 'Lainnya',
            ])->default('Rapat Koordinasi')->required(),
            DateTimePicker::make('waktu')->label('Tanggal dan waktu')->required(),
            TextInput::make('lokasi')->label('Tempat / tautan rapat')->maxLength(255),
            Select::make('bidang_id')->label('Bidang penyelenggara')->options(fn () => Bidang::query()->orderBy('nama')->pluck('nama', 'id'))->searchable()->nullable(),
            Textarea::make('peserta')->label('Peserta hadir')->rows(4)->helperText('Satu nama per baris.'),
            RichEditor::make('ringkasan_keputusan')->label('Ringkasan dan keputusan')->columnSpanFull(),
            TextInput::make('gdrive_url')->label('Tautan Google Drive')->url()->maxLength(2048)->rule('regex:/^https:\/\/(drive|docs)\.google\.com\//i')->helperText('Simpan notulensi panjang atau dokumentasi di Drive; pastikan izin berbagi Drive sesuai.'),
            TextInput::make('lokasi_fisik')->label('Lokasi arsip fisik')->maxLength(255)->helperText('Contoh: Lemari Sekretariat / Map Rapat 02.'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('waktu')->label('Waktu')->dateTime('d M Y, H:i')->sortable(),
            TextColumn::make('judul')->searchable()->sortable(),
            TextColumn::make('kategori')->badge()->sortable(),
            TextColumn::make('bidang.nama')->label('Bidang')->placeholder('Umum'),
            TextColumn::make('gdrive_url')->label('Drive')->url(fn ($record) => $record->gdrive_url, true)->placeholder('—'),
        ])->defaultSort('waktu', 'desc')->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListArsipRapat::route('/'), 'create' => Pages\CreateArsipRapat::route('/create'), 'edit' => Pages\EditArsipRapat::route('/{record}/edit')];
    }
}
