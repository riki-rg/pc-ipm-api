<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'url_gambar', // <--- JANGAN DIKOMEN BRO, INI PENTING!
        'video_id_youtube',
        'judul',
        'keterangan',
        'urutan',
    ];

    /**
     * Biar field 'gambar_url' otomatis muncul di JSON API
     */
    protected $appends = ['gambar_url'];

    /**
     * JURUS ACCESSOR (LOGIKA LINK)
     * Mengubah 'slides/foto.jpg' jadi 'http://127.0.0.1:8000/uploads/slides/foto.jpg'
     */
    protected function gambarUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // Ambil path raw dari database
                $path = $attributes['url_gambar'] ?? null;

                // Kalau kosong, balikin null
                if (!$path) return null;

                // Gabungin jadi link lengkap ke folder uploads
                return url('uploads/' . $path);
            },
        );
    }

    /**
     * HAPUS OTOMATIS
     * Kalau slide dihapus, file gambarnya juga ikut kehapus dari folder
     */
    protected static function booted()
    {
        static::deleting(function ($slide) {
            if ($slide->url_gambar) {
                Storage::disk('hosting_public')->delete($slide->url_gambar);
            }
        });
    }
}