<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class AlbumGaleri extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'cover',
        'kategori',
        'deskripsi',
    ];

    /**
     * Agar field 'cover_url' otomatis muncul di JSON API
     */
    protected $appends = ['cover_url'];

    public function fotoGaleri(): HasMany
    {
        return $this->hasMany(FotoGaleri::class, 'album_galeri_id');
    }

    /**
     * PERBAIKAN LOGIKA URL (PENTING!)
     * Kita arahkan ke folder 'uploads' langsung.
     */
    protected function coverUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // Ambil path raw dari database
                $path = $attributes['cover'] ?? null;

                // Kalau kosong, balikin null
                if (!$path) return null;

                // Hasilnya: http://127.0.0.1:8000/uploads/album-covers/foto.jpg
                return url('uploads/' . $path);
            },
        );
    }

    /**
     * TAMBAHAN: Hapus file fisik saat data dihapus
     */
    protected static function booted()
    {
        static::deleting(function ($album) {
            if ($album->cover) {
                // Hapus file dari folder public/uploads pake disk 'hosting_public'
                Storage::disk('hosting_public')->delete($album->cover);
            }
        });
    }
}