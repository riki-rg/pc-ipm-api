<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanResource\Pages;
use App\Models\Kegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class KegiatanResource extends Resource
{
    protected static ?string $model = Kegiatan::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Kegiatan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Detail Kegiatan')
                ->schema([
                    Forms\Components\TextInput::make('judul')
                        ->label('Nama Kegiatan')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                        ->maxLength(255),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('lokasi')
                        ->prefixIcon('heroicon-o-map-pin'),

                    Forms\Components\DateTimePicker::make('waktu')
                        ->label('Waktu Mulai')
                        ->required(),

                    Forms\Components\DateTimePicker::make('waktu_selesai')
                        ->label('Waktu Selesai'),
                ])->columns(2),

            Forms\Components\Section::make('Media & Panitia')
                ->schema([
                    Forms\Components\FileUpload::make('gambar')
                        ->label('Poster Kegiatan')
                        ->image()
                        ->directory('gambar-kegiatan') // Masuk ke uploads/gambar-kegiatan
                        ->maxSize(2048)
                        ->columnSpanFull(),

                    // Select Pengurus (Panitia)
                    Forms\Components\Select::make('penguruses')
                        ->label('Panitia (Pilih Pengurus)')
                        ->relationship('penguruses', 'nama_lengkap') // Pastikan di tabel pengurus kolomnya 'nama'
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->columnSpanFull(),
                ]),

            Forms\Components\RichEditor::make('deskripsi')
                ->label('Deskripsi Lengkap')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Poster')
                    ->circular(),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Nama Kegiatan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('waktu')
                    ->label('Mulai')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('lokasi')
                    ->limit(20),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKegiatans::route('/'),
            'create' => Pages\CreateKegiatan::route('/create'),
            'edit' => Pages\EditKegiatan::route('/{record}/edit'),
        ];
    }
}