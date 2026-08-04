<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Kajian extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'slug', 'jenis', 'pemateri', 'lokasi', 'waktu', 'deskripsi', 'gambar'];
    
    // INI KUNCINYA: Biar Frontend dapet field ini otomatis
    protected $appends = ['gambar_header_url', 'tanggal_formatted']; 

    // Auto Slug
    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->slug = Str::slug($model->judul));
        static::updating(fn ($model) => $model->slug = Str::slug($model->judul));
        
        // Auto Hapus Gambar
        static::deleting(function ($model) {
            if ($model->gambar) {
                // Hapus dari folder uploads
                $path = 'public/uploads/' . basename($model->gambar);
                if (Storage::exists($path)) Storage::delete($path);
            }
        });
    }

    // Jurus Link Gambar 'Direct' (/uploads/)
    protected function gambarHeaderUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $path = $attributes['gambar'] ?? null;
                if (!$path) return null;
                // Hasil: http://127.0.0.1:8000/uploads/gambar-kajian/foto.jpg
                return url('uploads/' . $path);
            },
        );
    }

    protected function tanggalFormatted(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => \Carbon\Carbon::parse($attributes['waktu'])->translatedFormat('d F Y'),
        );
    }
}