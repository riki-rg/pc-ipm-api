<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // <--- WAJIB ADA
use Illuminate\Support\Facades\Storage;

class Pengaturan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_website', 
        'logo', 
        'deskripsi_singkat',
        'email', 
        'whatsapp', 
        'instagram', 
        'youtube', 
        'alamat'
    ];

    // Ini yang bikin error tadi. Dia nyari fungsi logoUrl()
    protected $appends = ['logo_url'];

    // --- JURUS ACCESSOR (INI OBATNYA) ---
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // Ambil nama file dari database
                $path = $attributes['logo'] ?? null;
                
                // Kalo kosong, balikin null
                if (!$path) return null;

                // Gabungin jadi link lengkap: https://.../storage/logo/gambar.png
                return Storage::disk('public')->url($path);
            },
        );
    }

    // Hapus logo lama otomatis pas update
    protected static function booted()
    {
        static::updating(function ($pengaturan) {
            if ($pengaturan->isDirty('logo')) {
                $oldLogo = $pengaturan->getOriginal('logo');
                if ($oldLogo) {
                    Storage::disk('public')->delete($oldLogo);
                }
            }
        });
    }
}