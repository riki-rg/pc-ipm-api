<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class GantiPasswordAwal extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.ganti-password-awal';
    protected static ?string $slug = 'ganti-password';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Ganti kata sandi';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return (bool) auth()->user()?->must_change_password;
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('current_password')->label('Kata sandi sementara')->password()->required(),
            TextInput::make('password')->label('Kata sandi baru')->password()->required()->minLength(12)->confirmed(),
            TextInput::make('password_confirmation')->label('Ulangi kata sandi baru')->password()->required(),
        ])->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = auth()->user();

        if (! Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages(['data.current_password' => 'Kata sandi sementara tidak cocok.']);
        }

        $user->update(['password' => $data['password'], 'must_change_password' => false]);
        Notification::make()->title('Kata sandi berhasil diganti')->success()->send();
        $this->redirect('/admin');
    }

    public function logout(): void
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        $this->redirect('/admin/login');
    }
}
