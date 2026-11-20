<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArsipRapat extends Model
{
    protected $table = 'arsip_rapat';

    protected $fillable = [
        'judul', 'kategori', 'waktu', 'lokasi', 'bidang_id', 'peserta',
        'ringkasan_keputusan', 'gdrive_url', 'lokasi_fisik',
    ];

    protected $casts = ['waktu' => 'datetime'];

    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class);
    }
}
