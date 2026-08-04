<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Bidang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'icon',
        'deskripsi_singkat',
        'deskripsi_lengkap',
        'gambar_bidang',
    ];

    // Cuma satu appends buat Bidang
    protected $appends = ['gambar_url'];

    // GANTI JADI PLURAL: 'penguruses' (Karena satu bidang punya BANYAK pengurus)
    public function penguruses()
    {
        // Pastikan model Pengurus ada, dan foreign key-nya 'bidang_id'
        return $this->hasMany(Pengurus::class, 'bidang_id')->orderBy('urutan', 'asc');
    }

    // Accessor Gambar Bidang (Header/Poster Bidang)
    protected function gambarUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $path = $attributes['gambar_bidang'] ?? null;
                if (!$path) return null;
                return url('uploads/' . $path);
            },
        );
    }

    // Booted buat hapus gambar pas delete
    protected static function booted()
    {
        static::deleting(function ($bidang) {
            if ($bidang->gambar_bidang) {
                // Hapus manual dari public/uploads biar aman
                $path = public_path('uploads/' . $bidang->gambar_bidang);
                if (file_exists($path)) {
                    @unlink($path);
                }
            }
        });
    }
}