<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pangkat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pegawais(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }
}
