<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BidangResource\Pages;
use App\Models\Bidang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class BidangResource extends Resource
{
    protected static ?string $model = Bidang::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationGroup = 'Organisasi';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Bidang';
    protected static ?string $pluralModelLabel = 'Bidang';
    protected static ?string $modelLabel = 'Bidang';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->label('Nama Bidang')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            TextInput::make('icon')
                ->label('Ikon (Emoji 💡)')
                ->maxLength(10)
                ->default('💡'),

            FileUpload::make('gambar_bidang')
                ->label('Gambar Bidang')
                ->image()
                ->directory('gambar-bidang') // Masuk ke public/uploads/gambar-bidang
                ->disk('public')
                ->visibility('public')
                ->imageEditor()
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                ->maxSize(20480)
                ->helperText('Format: JPG, PNG, atau WebP. Maksimal 20MB.')
                ->columnSpanFull(),

            Textarea::make('deskripsi_singkat')
                ->label('Deskripsi Singkat')
                ->maxLength(255)
                ->columnSpanFull(),

            Textarea::make('deskripsi_lengkap')
                ->label('Deskripsi Lengkap')
                ->rows(5)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar_bidang')
                    ->label('Gambar')
                    ->square()
                    ->size(50),

                TextColumn::make('icon')
                    ->label('Ikon')
                    ->alignCenter(),

                TextColumn::make('nama')
                    ->label('Nama Bidang')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('deskripsi_singkat')
                    ->label('Deskripsi Singkat')
                    ->limit(50),
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
            'index' => Pages\ListBidangs::route('/'),
            'create' => Pages\CreateBidang::route('/create'),
            'edit' => Pages\EditBidang::route('/{record}/edit'),
        ];
    }
}