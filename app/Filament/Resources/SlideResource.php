<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlideResource\Pages;
use App\Models\Slide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class SlideResource extends Resource
{
    protected static ?string $model = Slide::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Publikasi';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Slide Hero';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Section::make('Tipe Slide')
                ->schema([
                    Select::make('type')
                        ->label('Jenis Slide')
                        ->options([
                            'image' => 'Gambar',
                            'video' => 'Video YouTube',
                        ])
                        ->required()
                        ->live(),
                ]),

            Section::make('Konten Slide')
                ->schema([
                    FileUpload::make('url_gambar')
                        ->label('Gambar')
                        ->image()
                        ->directory('gambar-slide')
                        ->disk('public')
                        ->visibility('public')
                        ->imageEditor()
                        ->acceptedFileTypes(['image/jpeg','image/png','image/webp'])
                        ->maxSize(20480)
                        ->helperText('Format: JPG, PNG, atau WebP. Maksimal 20MB. Resolusi lebar (16:6) paling pas untuk slider.')
                        ->columnSpanFull()
                        ->visible(fn ($get) => $get('type') === 'image'),

                    TextInput::make('video_id_youtube')
                        ->label('YouTube Video ID')
                        ->placeholder('Contoh: dQw4w9WgXcQ')
                        ->maxLength(100)
                        ->visible(fn ($get) => $get('type') === 'video'),
                ]),

            Section::make('Informasi Tambahan')
                ->schema([
                    TextInput::make('judul')
                        ->label('Judul Slide')
                        ->maxLength(255),

                    Textarea::make('keterangan')
                        ->label('Keterangan')
                        ->maxLength(500),

                    TextInput::make('urutan')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0)
                        ->required(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')->label('ID'),
            TextColumn::make('type')->label('Tipe')->sortable(),

            ImageColumn::make('url_gambar')
                ->label('Gambar')
                ->square(),
                //->visible(fn ($record) => $record->type === 'image'),

            TextColumn::make('video_id_youtube')
                ->label('Video ID')
                ->limit(20),
                //->visible(fn ($record) => $record->type === 'video'),

            TextColumn::make('judul')->label('Judul'),
            TextColumn::make('urutan')->label('Urutan')->sortable(),
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
            'index' => Pages\ListSlides::route('/'),
            'create' => Pages\CreateSlide::route('/create'),
            'edit' => Pages\EditSlide::route('/{record}/edit'),
        ];
    }
}
