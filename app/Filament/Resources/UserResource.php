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
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required(),
                DateTimePicker::make('email_verified_at')->default(now()),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->visibleOn('create')
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
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