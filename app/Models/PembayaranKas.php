<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Livewire\WithPagination;
use Livewire\Component;


class PembayaranKas extends Model
{
    public const NOMINAL_KAS = 10000;
    
    use HasFactory;

    protected $table = 'pembayaran_kas';

    protected $fillable = [
        'pengurus_id',
        'bulan',
        'tahun',
        'nominal',
        'status',
        'metode_bayar',
        'user_id_pencatat',
    ];

    protected $casts = [
        'bulan' => 'integer',
        'tahun' => 'integer',
        'nominal' => 'integer',
    ];

    public function pengurus()
    {
        return $this->belongsTo(Pengurus::class, 'pengurus_id');
    }

    public function pembayaranKas(): HasMany
    {
        return $this->hasMany(PembayaranKas::class, 'pengurus_id');
    }

    public function pencatat(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id_pencatat');
    }
}
