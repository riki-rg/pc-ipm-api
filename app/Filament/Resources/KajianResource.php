<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KajianResource\Pages;
use App\Models\Kajian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get; // Wajib import ini buat logika dinamis

class KajianResource extends Resource
{
    protected static ?string $model = Kajian::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Publikasi';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Kajian';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Pengaturan Tampilan')
                ->schema([
                    // 1. Radio Button buat milih Jenis
                    Forms\Components\Radio::make('jenis')
                        ->label('Mode Tampilan')
                        ->options([
                            'artikel' => '📝 Formal (Teks & Gambar)',
                            'poster' => '🖼️ Poster Only (Full Gambar)',
                        ])
                        ->default('artikel')
                        ->inline()
                        ->live() // PENTING: Biar form di bawahnya bereaksi langsung
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Detail Kajian')
                ->schema([
                    Forms\Components\TextInput::make('judul')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state)))
                        ->maxLength(255),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('pemateri')
                        ->prefix('Ustadz/ah'),

                    Forms\Components\TextInput::make('lokasi')
                        ->prefixIcon('heroicon-o-map-pin'),
                    
                    Forms\Components\DateTimePicker::make('waktu')
                        ->required(),
                ])->columns(2),

            Forms\Components\Section::make('Konten')
                ->schema([
                    // 2. Upload Gambar (Label berubah sesuai pilihan jenis)
                    Forms\Components\FileUpload::make('gambar')
                        ->label(fn (Get $get) => $get('jenis') === 'poster' ? 'Upload Poster (Wajib)' : 'Gambar Header')
                        ->image()
                        ->directory('gambar-kajian')
                        ->disk('public')
                        ->visibility('public')
                        ->imageEditor()
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(20480)
                        ->helperText('Format: JPG, PNG, atau WebP. Maksimal 20MB.')
                        ->required() // Selalu wajib biar gak kosong
                        ->columnSpanFull(),

                    // 3. Deskripsi (Hanya muncul kalau pilih ARTIKEL)
                    Forms\Components\RichEditor::make('deskripsi')
                        ->label('Isi Kajian / Notulensi')
                        ->placeholder('Tulis isi kajian di sini...')
                        ->toolbarButtons([
                            'bold', 'italic', 'underline', 'strike', 'link',
                            'h2', 'h3', 'bulletList', 'orderedList', 'blockquote',
                            'undo', 'redo',
                        ])
                        ->visible(fn (Get $get) => $get('jenis') === 'artikel') // Hilang kalau pilih Poster
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->label('No'),

                // Pake 'gambar', bukan 'gambar_kajian'
                Tables\Columns\ImageColumn::make('gambar') 
                    ->circular(),

                // Pake 'judul', bukan 'isi_kajian'
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),

                // Pake 'pemateri', bukan 'sumber'
                Tables\Columns\TextColumn::make('pemateri')
                    ->label('Pemateri')
                    ->searchable(),

                Tables\Columns\TextColumn::make('jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'artikel' => 'info',
                        'poster' => 'success',
                    }),
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
            'index' => Pages\ListKajians::route('/'),
            'create' => Pages\CreateKajian::route('/create'),
            'edit' => Pages\EditKajian::route('/{record}/edit'),
        ];
    }
}