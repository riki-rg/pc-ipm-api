<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengurusResource\Pages;
use App\Models\Pengurus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class PengurusResource extends Resource
{
    protected static ?string $model = Pengurus::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama_lengkap')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Select::make('jabatan')
                ->label('Jabatan')
                ->options([
                    'Ketua Umum' => 'Ketua Umum',
                    'Sekretaris Umum' => 'Sekretaris Umum',
                    'Bendahara Umum' => 'Bendahara Umum',
                    'Ketua Bidang' => 'Ketua Bidang',
                    'Sekretaris Bidang' => 'Sekretaris Bidang',
                    'Anggota' => 'Anggota',
                ])
                ->required()
                ->searchable(),

            Select::make('bidang_id')
                ->label('Bidang')
                ->relationship('bidang', 'nama')
                ->searchable()
                ->required(),

            FileUpload::make('foto_profil')
                ->label('Foto Profil')
                ->image()
                ->directory('foto-pengurus')
                ->maxSize(2048)
                ->visibility('public')
                ->avatar()
                ->columnSpanFull(),

            TextInput::make('periode')
                ->label('Periode')
                ->required()
                ->default('2025-2027'),

            TextInput::make('urutan')
                ->label('Urutan Tampilan')
                ->numeric()
                ->default(0),

            TextInput::make('whatsapp')
                ->label('Nomor WhatsApp')
                ->tel()
                ->maxLength(20)
                ->nullable(),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->maxLength(100)
                ->nullable(),

            TextInput::make('kutipan')
                ->label('Kutipan')
                ->maxLength(255)
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('foto_profil')->label('Foto')->circular(),
            TextColumn::make('nama_lengkap')->label('Nama')->searchable(),
            TextColumn::make('bidang.nama')->label('Bidang')->sortable(),
            TextColumn::make('jabatan')->label('Jabatan')->sortable(),
            TextColumn::make('periode')->label('Periode')->sortable(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public function pembayaranKas()
    {
        return $this->hasMany(\App\Models\PembayaranKas::class, 'pengurus_id');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenguruses::route('/'),
            'create' => Pages\CreatePengurus::route('/create'),
            'edit' => Pages\EditPengurus::route('/{record}/edit'),
        ];
    }
}
