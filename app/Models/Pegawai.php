<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class);
    }

    public function pangkat(): BelongsTo
    {
        return $this->belongsTo(Pangkat::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function pendidikanFormals(): HasMany
    {
        return $this->hasMany(PendidikanFormal::class);
    }

    public function pendidikanKursuses(): HasMany
    {
        return $this->hasMany(PendidikanKursus::class);
    }

    public function riwayatKepangkatans(): HasMany
    {
        return $this->hasMany(RiwayatKepangkatan::class);
    }

    public function riwayatJabatans(): HasMany
    {
        return $this->hasMany(RiwayatJabatan::class);
    }

    public function tandaJasas(): HasMany
    {
        return $this->hasMany(TandaJasa::class);
    }

    public function kunjunganLuarNegeris(): HasMany
    {
        return $this->hasMany(KunjunganLuarNegeri::class);
    }

    public function keteranganKeluargas(): HasMany
    {
        return $this->hasMany(KeteranganKeluarga::class);
    }

    public function keteranganOrganisasis(): HasMany
    {
        return $this->hasMany(KeteranganOrganisasi::class);
    }

    public function dokumenDigitals(): HasMany
    {
        return $this->hasMany(DokumenDigital::class);
    }
}
