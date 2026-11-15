<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // <-- Wajib import ini buat bikin Slug

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'isi_konten',
        'gambar_header',
        'status',
        'tanggal_publish',
        'user_id',
    ];

    // Biar link gambar muncul di JSON API
    protected $appends = ['gambar_header_url', 'tanggal_formatted'];

    // --- JURUS OTOMATIS (BOOT) ---
    protected static function booted()
    {
        // 1. Auto Slug pas Simpan
        static::creating(function ($artikel) {
            // Kalau slug kosong, bikin dari judul
            if (empty($artikel->slug)) {
                $artikel->slug = Str::slug($artikel->judul);
            }
        });

        // 2. Auto Hapus Gambar pas Artikel Dihapus
        static::deleting(function ($artikel) {
            if ($artikel->gambar_header) {
                Storage::disk('public')->delete($artikel->gambar_header);
            }
        });
    }

    // --- RELASI ---
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // --- ACCESSOR (Link Gambar Direct Upload) ---
    protected function gambarHeaderUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $path = $attributes['gambar_header'] ?? null;
                if (!$path) return null;
                
                // Hasil: https://.../storage/gambar-artikel/foto.jpg
                return Storage::disk('public')->url($path);
            },
        );
    }

    // --- FORMAT TANGGAL CANTIK ---
    protected function tanggalFormatted(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => \Carbon\Carbon::parse($attributes['created_at'])->translatedFormat('d F Y'),
        );
    }
}