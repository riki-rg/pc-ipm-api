<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengaturanResource\Pages;
use App\Models\Pengaturan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload; // Buat Upload
use Filament\Forms\Components\Textarea;   // Buat Deskripsi/Alamat
use Filament\Forms\Components\Section;    // Buat ngerapihin layout
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;   // <--- INI YG KURANG TADI
use Filament\Tables\Columns\ImageColumn;  // <--- INI YG KURANG TADI

// app/Filament/Resources/PengaturanResource.php
class PengaturanResource extends Resource
{
    protected static ?string $model = Pengaturan::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Pengaturan Web';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Identitas Website')
                ->schema([
                    TextInput::make('nama_website')->required(),
                    
                    FileUpload::make('logo') // Nah, ini enak skrg bisa khusus gambar
                        ->label('Logo Website')
                        ->image()
                        ->directory('logo') // public/uploads/logo
                        ->disk('public')
                        ->visibility('public')
                        ->imageEditor()
                        ->acceptedFileTypes(['image/jpeg','image/png','image/webp','image/svg+xml'])
                        ->maxSize(10240)
                        ->helperText('JPG/PNG/WebP/SVG, maks 10MB. Format persegi paling pas.'),
                        
                    Textarea::make('deskripsi_singkat')->columnSpanFull(),
                ]),

            Section::make('Kontak & Sosmed')
                ->schema([
                    TextInput::make('email')->email(),
                    TextInput::make('whatsapp')->numeric(),
                    TextInput::make('instagram')->prefix('instagram.com/'),
                    TextInput::make('youtube')->prefix('youtube.com/'),
                    Textarea::make('alamat')->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('logo')->circular(),
            TextColumn::make('nama_website'),
            TextColumn::make('email'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->paginated(false); // Gak perlu pagination
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengaturans::route('/'),
            // Kita hapus 'create' biar admin gak bisa nambah data (cukup edit yg ada)
            'edit' => Pages\EditPengaturan::route('/{record}/edit'),
        ];
    }
    
    // Matikan tombol "New" di halaman list
    public static function canCreate(): bool
    {
       return Pengaturan::count() === 0; // Cuma bisa create kalau data masih kosong
    }
}
