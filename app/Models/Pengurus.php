<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute; // Pake yang modern
use Illuminate\Support\Facades\Storage;

class Pengurus extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'jabatan',
        'foto_profil', // Kolom asli di Database
        'periode',
        'urutan',
        'bidang_id',
        'whatsapp',
        'email',
        'kutipan',
    ];

    // INI KUNCINYA: Biar di JSON muncul field 'foto_url'
    protected $appends = ['foto_url'];

    // --- RELASI (TETAP SAMA) ---
    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function pembayaranKas(): HasMany
    {
        return $this->hasMany(PembayaranKas::class, 'pengurus_id');
    }

    public function kegiatans(): BelongsToMany
    {
        return $this->belongsToMany(Kegiatan::class, 'kegiatan_pengurus')->withTimestamps();
    }

    public function kasTerbaru()
    {
        return $this->hasMany(PembayaranKas::class)->latest();
    }

    // --- ACCESSOR BARU (JEMBATAN FRONTEND) ---
    // Frontend minta 'foto_url', Database punya 'foto_profil'. Kita hubungkan di sini.
    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // Ambil path dari kolom 'foto_profil'
                $path = $attributes['foto_profil'] ?? null;
                
                if (!$path) return null;

                // Return URL lengkap lewat storage disk public
                // Hasil: https://.../storage/foto-pengurus/wajah.jpg
                return Storage::disk('public')->url($path);
            },
        );
    }

    // --- LOGIC HAPUS GAMBAR (DIPERBARUI DIKIT) ---
    protected static function booted()
    {
        static::deleting(function ($pengurus) {
            if ($pengurus->foto_profil) {
                Storage::disk('public')->delete($pengurus->foto_profil);
            }
        });
    }
}