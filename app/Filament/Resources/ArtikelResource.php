<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtikelResource\Pages;
use App\Models\Artikel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section; // Pake Section biar rapi
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Str; // Import Str

class ArtikelResource extends Resource
{
    protected static ?string $model = Artikel::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Artikel / Berita';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Konten Utama')
                ->schema([
                    TextInput::make('judul')
                        ->required()
                        ->live(onBlur: true) // Nunggu selesai ketik baru update slug
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                        ->maxLength(255),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true) // Gak boleh kembar
                        ->maxLength(255),

                    FileUpload::make('gambar_header')
                        ->label('Gambar Header')
                        ->image()
                        ->directory('gambar-artikel') // Masuk ke public/uploads/gambar-artikel
                        // HAPUS ->visibility('public') biar aman
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(2048)
                        ->columnSpanFull(),

                    RichEditor::make('isi_konten')
                        ->label('Isi Artikel')
                        ->required()
                        ->columnSpanFull(),
                ])->columnSpan(2),

            Section::make('Meta Data')
                ->schema([
                    Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                        ])
                        ->default('draft')
                        ->required(),

                    DateTimePicker::make('tanggal_publish')
                        ->default(now()),

                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->label('Penulis')
                        ->default(auth()->id())
                        ->required(),
                ])->columnSpan(1),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->label('No'),
                
                ImageColumn::make('gambar_header')
                    ->label('Cover')
                    ->square(),

                TextColumn::make('judul')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                    }),

                TextColumn::make('user.name')->label('Penulis'),
                
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArtikels::route('/'),
            'create' => Pages\CreateArtikel::route('/create'),
            'edit' => Pages\EditArtikel::route('/{record}/edit'),
        ];
    }
}