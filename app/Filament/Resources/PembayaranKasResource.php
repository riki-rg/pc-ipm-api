<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranKasResource\Pages;
use App\Models\PembayaranKas;
use App\Models\Pengurus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class PembayaranKasResource extends Resource
{
    protected static ?string $model = PembayaranKas::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Pembayaran Kas';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([

                Select::make('pengurus_id')
                    ->label('Pengurus')
                    ->relationship(
                        name: 'pengurus',
                        titleAttribute: 'nama_lengkap'
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('bulan')
                    ->label('Bulan')
                    ->options([
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember',
                    ])
                    ->required(),

                Select::make('tahun')
                    ->label('Tahun')
                    ->options(fn () => tahun_options())
                    ->required(),

                TextInput::make('nominal')
                    ->label('Nominal (per bulan)')
                    ->default(PembayaranKas::NOMINAL_KAS ?? 10000)
                    ->disabled(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'belum' => 'Belum',
                        'sudah' => 'Sudah',
                    ])
                    ->default('belum')
                    ->required(),

                Select::make('metode_bayar')
                    ->label('Metode Bayar')
                    ->options([
                        'transfer' => 'Transfer',
                        'cash' => 'Cash',
                        'kajian_internal' => 'Pembayaran di Kajian',
                    ])
                    ->nullable(),

                Select::make('user_id_pencatat')
                    ->label('Dicatat Oleh')
                    ->relationship('pencatat', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('pengurus.nama_lengkap')->label('Pengurus')->sortable()->searchable(),

            TextColumn::make('bulan')->label('Bulan')
                ->formatStateUsing(fn ($state) => [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                ][$state] ?? $state),

            TextColumn::make('tahun')->label('Tahun')->sortable(),

            TextColumn::make('nominal')->money('IDR', true)->label('Nominal'),

            TextColumn::make('metode_bayar')->label('Metode'),

            BadgeColumn::make('status')
                ->label('Status')
                ->colors([
                    'danger' => 'belum',
                    'success' => 'sudah',
                ])
                ->formatStateUsing(fn ($state) => $state === 'sudah' ? 'Sudah' : 'Belum'),

            TextColumn::make('pencatat.name')->label('Dicatat Oleh'),
        ])
        ->filters([
            SelectFilter::make('tahun')->options(fn () =>
                tahun_options()
            ),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembayaranKas::route('/'),
            'create' => Pages\CreatePembayaranKas::route('/create'),
            'edit' => Pages\EditPembayaranKas::route('/{record}/edit'),
            'rekap' => Pages\RekapPembayaranKas::route('/rekap'),
        ];
    }
}

