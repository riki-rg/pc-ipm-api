<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // <--- INI BALIK
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'slug', 'lokasi', 'waktu', 'waktu_selesai', 'deskripsi', 'gambar'
    ];
    
    // Biar Frontend Next.js otomatis dapet link gambar & tanggal
    protected $appends = ['gambar_header_url', 'tanggal_formatted'];

    // --- RELASI PENGURUS (PANITIA) BALIK LAGI ---
    public function penguruses(): BelongsToMany
    {
        return $this->belongsToMany(Pengurus::class, 'kegiatan_pengurus');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->slug = Str::slug($model->judul));
        static::updating(fn ($model) => $model->slug = Str::slug($model->judul));
    }

    // Accessor buat Frontend (Biar gambar nongol)
    protected function gambarHeaderUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $path = $attributes['gambar'] ?? null;
                if (!$path) return null;
                return url('uploads/' . $path);
            },
        );
    }

    // Format tanggal buat kartu di Frontend
    protected function tanggalFormatted(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => \Carbon\Carbon::parse($attributes['waktu'])->translatedFormat('d F Y'),
        );
    }
}