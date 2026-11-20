<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Pengurus;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    private ?string $temporaryPassword = null;
    private ?string $generatedUsername = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $pengurus = Pengurus::findOrFail($data['pengurus_id']);
        $base = Str::slug($pengurus->nama_lengkap) ?: 'anggota';
        $username = $base;
        $suffix = 2;

        while (User::where('email', $username . '@pc.ipm.mayong.com')->exists()) {
            $username = $base . $suffix++;
        }

        $this->generatedUsername = $username . '@pc.ipm.mayong.com';
        $this->temporaryPassword = Str::password(18);
        $data['name'] = $pengurus->nama_lengkap;
        $data['email'] = $this->generatedUsername;
        $data['password'] = Hash::make($this->temporaryPassword);
        $data['email_verified_at'] = now();
        $data['must_change_password'] = true;

        return $data;
    }

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Akun berhasil dibuat')
            ->body("Username: {$this->generatedUsername}\nKata sandi sementara: {$this->temporaryPassword}\nCatat dan sampaikan secara pribadi. Kata sandi ini hanya ditampilkan sekali.")
            ->success()
            ->send();
        $this->temporaryPassword = null;
    }
}
