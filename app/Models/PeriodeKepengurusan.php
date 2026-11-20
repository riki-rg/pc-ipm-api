<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodeKepengurusan extends Model
{
    protected $table = 'periode_kepengurusan';

    protected $fillable = ['nama', 'mulai', 'selesai'];

    protected $casts = ['mulai' => 'date', 'selesai' => 'date'];

    public function programKerja(): HasMany
    {
        return $this->hasMany(ProgramKerja::class, 'periode_id');
    }
}
