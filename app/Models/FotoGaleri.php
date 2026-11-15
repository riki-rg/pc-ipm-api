<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class FotoGaleri extends Model
{
    use HasFactory;

    // Pastikan nama kolom gambarnya bener (misal: 'foto' atau 'path')
    // Sesuaikan dengan migration lo. Disini gua asumsi namanya 'foto'
    protected $fillable = ['album_galeri_id', 'foto']; 

    protected $appends = ['foto_url'];

    // Relasi balik ke Album (Opsional tapi bagus ada)
    public function album()
    {
        return $this->belongsTo(AlbumGaleri::class, 'album_galeri_id');
    }

    // Jurus URL Gambar
    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $path = $attributes['foto'] ?? null;
                if (!$path) return null;
                return Storage::disk('public')->url($path);
            },
        );
    }
    
    // Hapus file fisik pas data dihapus
    protected static function booted()
    {
        static::deleting(function ($item) {
            if ($item->foto) {
                 Storage::disk('public')->delete($item->foto);
            }
        });
    }
}