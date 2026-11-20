<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramKerja extends Model
{
    protected $table = 'program_kerja';

    protected $fillable = [
        'periode_id', 'bidang_id', 'nama', 'mulai', 'selesai', 'status',
        'catatan', 'gdrive_url', 'lokasi_fisik',
    ];

    protected $casts = ['mulai' => 'date', 'selesai' => 'date'];

    public function periode(): BelongsTo
    {
        return $this->belongsTo(PeriodeKepengurusan::class, 'periode_id');
    }

    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class);
    }

    protected static function booted(): void
    {
        static::saving(function (self $program): void {
            $periode = PeriodeKepengurusan::find($program->periode_id);
            if (! $periode) {
                throw \Illuminate\Validation\ValidationException::withMessages(['periode_id' => 'Periode kepengurusan tidak ditemukan.']);
            }

            $mulai = \Illuminate\Support\Carbon::parse($program->mulai);
            $periodeMulai = $periode->mulai;
            $periodeSelesai = $periode->selesai;
            if ($mulai->lt($periodeMulai) || $mulai->gt($periodeSelesai)) {
                throw \Illuminate\Validation\ValidationException::withMessages(['mulai' => 'Tanggal proker harus berada dalam periode kepengurusan.']);
            }

            if ($program->selesai) {
                $selesai = \Illuminate\Support\Carbon::parse($program->selesai);
                if ($selesai->lt($mulai) || $selesai->gt($periodeSelesai)) {
                    throw \Illuminate\Validation\ValidationException::withMessages(['selesai' => 'Tanggal selesai harus setelah tanggal mulai dan masih dalam periode kepengurusan.']);
                }
            }
        });
    }
}
