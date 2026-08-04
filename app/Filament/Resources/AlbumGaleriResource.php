<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlbumGaleriResource\Pages;
use App\Models\AlbumGaleri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class AlbumGaleriResource extends Resource
{
    protected static ?string $model = AlbumGaleri::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Album Galeri';

    public static function form(Form $form): Form
    {
        return $form->schema([

            // --- BAGIAN 1: DATA UTAMA ---
            Section::make('Informasi Album')
                ->schema([
                    TextInput::make('judul')
                        ->label('Judul Album')
                        ->required()
                        ->maxLength(255),

                    Select::make('kategori')
                        ->label('Kategori')
                        ->options([
                            'Kegiatan' => 'Kegiatan',
                            'Kajian' => 'Kajian',
                            'Lainnya' => 'Lainnya',
                        ])
                        ->required(),
                ])->columns(2),

            // --- BAGIAN 2: COVER ALBUM ---
            Section::make('Cover Depan')
                ->schema([
                    FileUpload::make('cover')
                        ->label('Cover Album (Satu Foto)')
                        ->image()
                        ->directory('album-covers')
                        ->maxSize(3072)
                        ->required()
                        ->columnSpanFull(),
                ]),

            // --- BAGIAN 3: DESKRIPSI ---
            Section::make('Deskripsi')
                ->schema([
                    Textarea::make('deskripsi')
                        ->label('Deskripsi')
                        ->rows(3),
                ])->columnSpanFull(),

            // --- BAGIAN 4: ISI FOTO (INI YANG BARU!) ---
            // Jurus Repeater: "Masukin banyak foto galeri ke dalam album ini"
            Section::make('Isi Galeri Foto')
                ->description('Upload foto-foto dokumentasi di sini')
                ->schema([
                    Forms\Components\Repeater::make('fotoGaleri') // <-- Harus sama dengan nama fungsi relasi di Model
                        ->relationship() // <-- Ini kuncinya! Biar otomatis nyimpen ke tabel anak
                        ->schema([
                            FileUpload::make('foto')
                                ->label('Foto')
                                ->image()
                                ->directory('galeri-foto') // Masuk ke folder uploads/galeri-foto
                                ->required(),
                                
                            TextInput::make('keterangan')
                                ->label('Caption Foto (Opsional)')
                                ->placeholder('Lagi ngapain...')
                        ])
                        ->grid(2) // Biar tampilan formnya berjejer 2 kolom
                        ->defaultItems(1) // Default nongol 1 kotak upload
                        ->addActionLabel('Tambah Foto Lain'), // Tombol nambahnya
                ]),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            // PERBAIKAN TABLE:
            // Panggil 'cover', bukan 'cover_url'
            ImageColumn::make('cover')
                ->label('Cover')
                ->square(), // Atau circular(), bebas

            TextColumn::make('judul')
                ->label('Judul')
                ->searchable()
                ->limit(40),

            TextColumn::make('kategori')
                ->label('Kategori')
                ->badge() // Pake badge biar keren
                ->color(fn (string $state): string => match ($state) {
                    'Kegiatan' => 'success',
                    'Kajian' => 'warning',
                    'Lainnya' => 'gray',
                    default => 'gray',
                })
                ->sortable(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(), // Tambahin Delete biar bisa hapus
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
            'index' => Pages\ListAlbumGaleris::route('/'),
            'create' => Pages\CreateAlbumGaleri::route('/create'),
            'edit' => Pages\EditAlbumGaleri::route('/{record}/edit'),
        ];
    }
}