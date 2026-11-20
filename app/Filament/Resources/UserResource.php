<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Manajemen User';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pengurus_id')
                    ->label('Pengurus')
                    ->options(fn () => \App\Models\Pengurus::query()->whereDoesntHave('user')->orderBy('nama_lengkap')->pluck('nama_lengkap', 'id'))
                    ->searchable()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->visibleOn('create'),
                TextInput::make('name')->required()->visibleOn('edit'),
                TextInput::make('email')->required()->visibleOn('edit'),
                DateTimePicker::make('email_verified_at')->default(now())->visibleOn('edit'),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->default(fn () => array_filter([\Spatie\Permission\Models\Role::where('name', 'anggota')->value('id')]) )
                    ->preload()
                    ->searchable()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('roles.name')->label('Jabatan')->searchable(),
                IconColumn::make('email_verified_at')->label('Terverifikasi')->boolean(),
            ])
            ->filters([])
            ->actions([ Tables\Actions\EditAction::make(), ])
            ->bulkActions([ Tables\Actions\BulkActionGroup::make([ Tables\Actions\DeleteBulkAction::make(), ]), ]);
    }
    
    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
}