<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FotoGaleriResource\Pages;
use App\Models\FotoGaleri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class FotoGaleriResource extends Resource
{
    protected static ?string $model = FotoGaleri::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Foto Galeri';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Section::make('Foto')
                ->schema([
                    FileUpload::make('foto_url')
                        ->label('Foto')
                        ->image()
                        ->directory('galeri/foto')
                        ->disk('public')
                        ->visibility('public')
                        ->imageEditor()
                        ->acceptedFileTypes(['image/jpeg','image/png','image/webp'])
                        ->maxSize(20480)
                        ->helperText('JPG/PNG/WebP, maks 20MB.')
                        ->required(),
                ])
                ->columnSpanFull(),

            Section::make('Detail')
                ->schema([
                    Select::make('album_galeri_id')
                        ->label('Album Galeri')
                        ->relationship('album', 'judul')
                        ->searchable()
                        ->required(),

                    Textarea::make('keterangan')
                        ->label('Keterangan')
                        ->rows(3)
                        ->maxLength(500),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('foto_url')
                ->label('Foto')
                ->square(),

            TextColumn::make('album.judul')
                ->label('Album')
                ->searchable(),

            TextColumn::make('keterangan')
                ->limit(30)
                ->label('Keterangan'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFotoGaleris::route('/'),
            'create' => Pages\CreateFotoGaleri::route('/create'),
            'edit' => Pages\EditFotoGaleri::route('/{record}/edit'),
        ];
    }
}
